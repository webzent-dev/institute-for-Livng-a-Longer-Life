<?php

namespace App\Console\Commands;

use App\Mail\MembershipRenewalReminder;
use App\Models\EmailLog;
use App\Models\EmailSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMembershipRenewalReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:send-renewal-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email members whose membership is about to expire (7 days and 1 day before) or has just expired, prompting them to renew.';

    /**
     * Days-before-expiry marks at which a reminder is sent. Using fixed marks means
     * each member is emailed at most once per mark, so a daily run never spams them
     * (no extra DB column needed to de-duplicate).
     *
     * A value of 0 means "expired today".
     */
    private const REMINDER_DAYS = [7, 1, 0];

    public function handle(): int
    {
        // Respect the admin's on/off switch (Email Management > Templates).
        if (!EmailSetting::isEnabled('renewal_reminder')) {
            $this->info('Membership renewal reminders are disabled in Email Management. Nothing sent.');
            return self::SUCCESS;
        }

        $today = Carbon::today();

        // Only real members holding a paid plan. Lifetime plans sit ~100 years out and
        // therefore never land on one of the reminder marks, so they're excluded naturally.
        $members = User::where('role', 'user')
            ->where('plan_id', '>', 0)
            ->whereNotNull('plan_expiry')
            ->get();

        $sent = 0;

        foreach ($members as $member) {
            if (strtolower((string) $member->plan_period) === 'lifetime') {
                continue;
            }

            // Members on automatic renewal are charged by membership:auto-renew and
            // must not be told to renew by hand. That command emails them itself if
            // the charge fails.
            if ($member->shouldAutoRenew()) {
                continue;
            }

            $expiry = Carbon::parse($member->plan_expiry)->startOfDay();
            $daysLeft = (int) $today->diffInDays($expiry, false);

            if (!in_array($daysLeft, self::REMINDER_DAYS, true)) {
                continue;
            }

            $mailable = new MembershipRenewalReminder($member, $daysLeft);
            $subject = $mailable->build()->subject;

            try {
                Mail::to($member->email)->send($mailable);
                $sent++;
                $this->info("Reminder sent to {$member->email} ({$daysLeft} day(s) left).");

                EmailLog::create([
                    'recipient_email' => $member->email,
                    'recipient_type' => 'user',
                    'recipient_id' => $member->id,
                    'subject' => $subject,
                    'message' => 'Membership renewal reminder (' . $daysLeft . ' day(s) left).',
                    'email_type' => 'renewal_reminder',
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            } catch (\Throwable $e) {
                $this->error("Failed to email {$member->email}: {$e->getMessage()}");
                \Log::error('Membership renewal reminder failed for user ' . $member->id . ': ' . $e->getMessage());

                EmailLog::create([
                    'recipient_email' => $member->email,
                    'recipient_type' => 'user',
                    'recipient_id' => $member->id,
                    'subject' => $subject,
                    'message' => 'Membership renewal reminder (' . $daysLeft . ' day(s) left).',
                    'email_type' => 'renewal_reminder',
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }
        }

        $this->info("Done. {$sent} reminder(s) sent.");

        return self::SUCCESS;
    }
}

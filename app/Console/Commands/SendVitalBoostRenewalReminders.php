<?php

namespace App\Console\Commands;

use App\Mail\VitalBoostRenewalReminder;
use App\Models\EmailLog;
use App\Models\EmailSetting;
use App\Models\VitalBoostSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendVitalBoostRenewalReminders extends Command
{
    protected $signature = 'vital-boost:send-renewal-reminders';

    protected $description = 'Email Vital Boost subscribers 7 days and 1 day before their subscription renews, and on the renewal day.';

    /** Days-before-renewal marks; 0 means "due today". Fixed marks avoid duplicate sends. */
    private const REMINDER_DAYS = [7, 1, 0];

    /** Toggle key in the admin Email Management system. */
    private const EMAIL_TYPE = 'vital_boost_renewal_reminder';

    public function handle(): int
    {
        if (!EmailSetting::isEnabled(self::EMAIL_TYPE)) {
            $this->info('Vital Boost renewal reminders are disabled in Email Management. Nothing sent.');
            return self::SUCCESS;
        }

        $today = Carbon::today();

        $subscriptions = VitalBoostSubscription::active()
            ->whereNotNull('next_billing_at')
            ->get();

        $sent = 0;

        foreach ($subscriptions as $subscription) {
            $renewal = Carbon::parse($subscription->next_billing_at)->startOfDay();
            $daysLeft = (int) $today->diffInDays($renewal, false);

            if (!in_array($daysLeft, self::REMINDER_DAYS, true)) {
                continue;
            }

            $email = $subscription->email
                ?: optional($subscription->user)->email;

            if (empty($email)) {
                continue;
            }

            $mailable = new VitalBoostRenewalReminder($subscription, $daysLeft);
            $subject = $mailable->build()->subject;

            try {
                Mail::to($email)->send($mailable);
                $sent++;
                $this->info("Reminder sent to {$email} ({$daysLeft} day(s) left).");

                EmailLog::create([
                    'recipient_email' => $email,
                    'recipient_type'  => 'user',
                    'recipient_id'    => $subscription->user_id,
                    'subject'         => $subject,
                    'message'         => 'Vital Boost renewal reminder (' . $daysLeft . ' day(s) left).',
                    'email_type'      => self::EMAIL_TYPE,
                    'status'          => 'sent',
                    'sent_at'         => now(),
                ]);
            } catch (\Throwable $e) {
                $this->error("Failed to email {$email}: {$e->getMessage()}");
                \Log::error('Vital Boost renewal reminder failed for subscription ' . $subscription->id . ': ' . $e->getMessage());

                EmailLog::create([
                    'recipient_email' => $email,
                    'recipient_type'  => 'user',
                    'recipient_id'    => $subscription->user_id,
                    'subject'         => $subject,
                    'message'         => 'Vital Boost renewal reminder (' . $daysLeft . ' day(s) left).',
                    'email_type'      => self::EMAIL_TYPE,
                    'status'          => 'failed',
                    'error_message'   => $e->getMessage(),
                ]);
            }
        }

        $this->info("Done. {$sent} reminder(s) sent.");

        return self::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Mail\MembershipRenewalReminder;
use App\Models\User;
use App\Services\MembershipRenewalService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RenewMemberships extends Command
{
    protected $signature = 'membership:auto-renew {--dry-run : List who would be charged without charging anyone}';

    protected $description = 'Charge the saved card of members who opted into automatic renewal and whose membership is due.';

    /**
     * Days-past-expiry on which we attempt the charge. 0 is expiry day; the two
     * retries cover a card that was temporarily declined. A successful charge
     * pushes plan_expiry forward, so a renewed member falls out of this window
     * on the next run — that is what stops us charging twice.
     */
    private const ATTEMPT_DAYS = [0, -1, -2];

    public function handle(MembershipRenewalService $renewals): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $today = Carbon::today();

        $members = User::where('role', 'user')
            ->where('status', 'active')
            ->where('plan_id', '>', 0)
            ->where('auto_renew', true)
            ->whereNull('membership_cancelled_at')   // cancelled members are never charged
            ->whereNotNull('plan_expiry')
            ->get();

        $charged = 0;
        $failed = 0;

        foreach ($members as $member) {
            // Belt and braces: the model owns the rule, the query above only mirrors it.
            if (!$member->shouldAutoRenew()) {
                continue;
            }

            $expiry = Carbon::parse($member->plan_expiry)->startOfDay();
            $daysLeft = (int) $today->diffInDays($expiry, false);

            if (!in_array($daysLeft, self::ATTEMPT_DAYS, true)) {
                continue;
            }

            if ($dryRun) {
                $this->line("[dry-run] would charge {$member->email} \${$member->plan_price} ({$member->plan_name}, {$daysLeft} day(s) left)");
                $charged++;
                continue;
            }

            $result = $renewals->renewOffSession($member);

            if ($result['ok']) {
                $charged++;
                $this->info("Renewed {$member->email} until " . Carbon::parse($member->fresh()->plan_expiry)->format('M j, Y'));
                continue;
            }

            $failed++;
            $this->error("Could not renew {$member->email}: {$result['message']}");
            Log::warning('Auto-renewal failed', ['user_id' => $member->id, 'reason' => $result['message']]);

            // Tell them once, on the first attempt, so they can renew by hand.
            // The retries on the following days stay quiet.
            if ($daysLeft === 0 && !empty($member->email)) {
                try {
                    Mail::to($member->email)->send(new MembershipRenewalReminder($member, $daysLeft));
                } catch (\Throwable $e) {
                    Log::error('Auto-renewal failure notice could not be sent: ' . $e->getMessage(), ['user_id' => $member->id]);
                }
            }
        }

        $this->info($dryRun
            ? "Dry run complete. {$charged} member(s) would be charged."
            : "Done. {$charged} renewed, {$failed} failed.");

        return self::SUCCESS;
    }
}

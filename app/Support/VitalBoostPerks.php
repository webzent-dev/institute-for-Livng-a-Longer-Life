<?php

namespace App\Support;

/**
 * The one-line perk caption shown under a Vital Boost purchase option.
 *
 * Lives in PHP rather than in each page's JavaScript so the shop grid and the
 * product detail page word the offer identically. Both read it from the pricing
 * payload; neither decides it for itself.
 */
class VitalBoostPerks
{
    /**
     * Caption for a single purchase option, or an empty string when the option
     * carries no perks (a one-time purchase, or a member on a monthly plan).
     *
     * A yearly plan earns both a discount and free shipping. When both apply the
     * wording is shortened so the caption still fits one line on a product card
     * — the long form wraps and makes every card in the row taller.
     *
     * @param array<string, mixed> $breakdown A PricingBreakdown::toArray() result.
     */
    public static function label(array $breakdown): string
    {
        $percent   = (float) ($breakdown['subscription_percent'] ?? 0);
        $shipsFree = (bool) ($breakdown['shipping_waived'] ?? false);

        // Members receive their membership discount instead of the subscription
        // one, so their percent is zero and the caption must not promise a
        // saving they will not get.
        $saving = $percent > 0 ? self::formatPercent($percent) : null;

        if ($saving && $shipsFree) {
            return "Save {$saving}% · Free shipping";
        }

        if ($saving) {
            return "Save {$saving}% with a subscription";
        }

        return $shipsFree ? 'Free shipping' : '';
    }

    /**
     * Trim pointless decimals: 5.00 reads as 5, but 7.50 keeps its half.
     */
    private static function formatPercent(float $percent): string
    {
        return rtrim(rtrim(number_format($percent, 2, '.', ''), '0'), '.');
    }
}

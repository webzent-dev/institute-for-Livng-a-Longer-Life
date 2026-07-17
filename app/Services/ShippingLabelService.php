<?php

namespace App\Services;

use App\Models\SubOrder;
use Illuminate\Support\Facades\Log;

class ShippingLabelService
{
    public function __construct(protected ShippoService $shippoService)
    {
    }

    /**
     * Purchase a Shippo label for a single sub-order and persist the result.
     *
     * Labels are always bought one sub-order at a time. A sub-order holds the
     * items of exactly one seller, so each seller's parcel ships from its own
     * origin address and needs its own rate.
     *
     * @return array{ok: bool, message: string}
     */
    public function purchase(SubOrder $subOrder): array
    {
        // Don't regenerate if label already exists — a second purchase is billable.
        if ($subOrder->label_url) {
            return ['ok' => false, 'message' => 'Label already generated. Download it below.'];
        }

        if (!$subOrder->shippo_rate_id) {
            return ['ok' => false, 'message' => 'No shipping rate available. Please contact support.'];
        }

        try {
            $transaction = $this->shippoService->purchaseLabel($subOrder->shippo_rate_id);
        } catch (\Exception $e) {
            Log::error('Label generation failed: ' . $e->getMessage(), [
                'sub_order_id' => $subOrder->id,
            ]);

            return ['ok' => false, 'message' => 'Label generation failed. Please try again.'];
        }

        if (($transaction['status'] ?? null) !== 'SUCCESS') {
            $errorMsg = isset($transaction['messages'])
                ? collect($transaction['messages'])->pluck('text')->implode(', ')
                : '';

            return [
                'ok' => false,
                'message' => 'Label generation failed: ' . ($errorMsg ?: 'Unknown error'),
            ];
        }

        $subOrder->update([
            'shippo_transaction_id' => $transaction['object_id'] ?? null,
            'label_url' => $transaction['label_url'] ?? null,
            'label_pdf_url' => $transaction['label_url'] ?? null,
            'tracking_number' => $transaction['tracking_number'] ?? $subOrder->tracking_number,
            'carrier' => $transaction['rate']['provider'] ?? $subOrder->carrier,
            'label_created_at' => now(),
        ]);

        return ['ok' => true, 'message' => 'Shipping label generated successfully!'];
    }
}

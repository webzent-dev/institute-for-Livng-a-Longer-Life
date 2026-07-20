<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\CollaboratorBankDetails;
use App\Models\CollaboratorBusinessDetails;
use App\Models\Course;
use App\Models\Product;
use App\Models\SubOrder;
use App\Models\User;

/**
 * Assembles everything the admin collaborator profile shows about one
 * collaborator.
 *
 * The counterpart to MemberProfileService: kept out of the controller so each
 * tab's query sits next to the others and the eager loading is visible in one
 * place.
 */
class CollaboratorProfileService
{
    public function __construct(
        private ShippingService $shipping,
    ) {
    }

    public function businessDetails(User $collaborator): ?CollaboratorBusinessDetails
    {
        return CollaboratorBusinessDetails::where('user_id', $collaborator->id)->first();
    }

    public function bankDetails(User $collaborator): ?CollaboratorBankDetails
    {
        return CollaboratorBankDetails::where('user_id', $collaborator->id)->first();
    }

    /**
     * Payout details reduced to what an admin needs to recognise the account,
     * never enough to move money out of it.
     *
     * The account number and IBAN identify the account itself, so only their
     * last four digits are returned. The bank name, routing and SWIFT codes
     * identify the *bank* rather than the account and are needed to reconcile a
     * payout, so those stay readable — which is what this screen already showed.
     *
     * @return array<string, string|null>|null
     */
    public function maskedBankDetails(User $collaborator): ?array
    {
        $bank = $this->bankDetails($collaborator);

        if (!$bank) {
            return null;
        }

        return [
            'account_holder_name' => $bank->account_holder_name,
            'bank_name'           => $bank->bank_name,
            'account_type'        => $bank->account_type,
            'account_number'      => $this->maskAllButLast4($bank->account_number),
            'iban'                => $this->maskAllButLast4($bank->iban),
            'routing_number'      => $bank->routing_number,
            'swift_code'          => $bank->swift_code,
        ];
    }

    /**
     * Show only the final four characters of an account identifier.
     */
    private function maskAllButLast4(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        return '••••' . substr($value, -4);
    }

    /**
     * Products this collaborator sells, newest first.
     */
    public function products(User $collaborator)
    {
        return Product::where('user_id', $collaborator->id)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Courses (video library entries) this collaborator has uploaded.
     */
    public function courses(User $collaborator)
    {
        return Course::where('user_id', $collaborator->id)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * The collaborator's own shipments, newest first, one page at a time.
     *
     * Sales are read from sub-orders rather than order items: one sub-order per
     * seller is what the collaborator is actually paid and ships against.
     *
     * The page parameter is named `sales_page` so it cannot collide with any
     * other paginator on the profile, and `tab=sales` is appended so following a
     * page link returns to the Sales tab rather than the first one.
     *
     * Ordering falls back to the id because sub-orders written in the same
     * second share a created_at. Without a tiebreaker the sort is unspecified,
     * and a row can appear on two pages — or none — as the admin pages through.
     */
    public function subOrders(User $collaborator, int $perPage = 10)
    {
        return SubOrder::with(['order', 'items'])
            ->where('seller_id', $collaborator->id)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($perPage, ['*'], 'sales_page')
            ->appends(['tab' => 'sales']);
    }

    /**
     * Whether this collaborator can actually have labels bought for them.
     *
     * @return array{valid: bool, errors: array<int, string>}
     */
    public function shippingReadiness(User $collaborator): array
    {
        try {
            $result = $this->shipping->validateSellerShippingSetup($collaborator);

            return [
                'valid'  => (bool) ($result['is_valid'] ?? false),
                'errors' => $result['errors'] ?? [],
            ];
        } catch (\Exception $e) {
            // A misconfigured shipping provider must not take the profile down.
            return ['valid' => false, 'errors' => ['Shipping setup could not be checked.']];
        }
    }

    /**
     * Admin actions recorded against this collaborator, newest first.
     */
    public function activity(User $collaborator, int $limit = 50)
    {
        return AuditLog::with('actor')
            ->where('user_id', $collaborator->id)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Headline figures for the cards above the tabs.
     *
     * Deliberately computed with its own aggregate queries rather than from the
     * loaded collections: the Sales tab is paginated, so counting the rows on
     * screen would report one page's worth of revenue as the lifetime total.
     *
     * @return array<string, mixed>
     */
    public function summary(User $collaborator): array
    {
        $sales = fn () => SubOrder::where('seller_id', $collaborator->id);
        $open = fn () => $sales()->whereNotIn('status', ['delivered', 'cancelled']);

        return [
            'product_count'   => Product::where('user_id', $collaborator->id)->count(),
            'active_products' => Product::where('user_id', $collaborator->id)->where('status', 'active')->count(),
            'course_count'    => Course::where('user_id', $collaborator->id)->count(),
            'sales_count'     => $sales()->count(),
            // Cancelled shipments were never earned, so they are left out of revenue.
            'revenue'         => $sales()->where('status', '!=', 'cancelled')->sum('total'),
            'open_shipments'  => $open()->count(),
            'awaiting_label'  => $open()
                ->where(fn ($query) => $query->whereNull('label_pdf_url')->orWhere('label_pdf_url', ''))
                ->count(),
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'country',
        'payment_method',
        'subtotal',
        'shipping_method',
        'shipping_cost',
        'tax',
        'discount',
        'membership_discount',
        'membership_plan_name',
        'subscription_discount',
        'total',
        'status',
        'payment_status',
        'billing_address',
        'shipping_address',
        'notes',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function subOrders()
    {
        return $this->hasMany(SubOrder::class);
    }

    /**
     * Whether this order can be viewed in the member dashboard.
     *
     * Guest checkouts have no account to sign in to, so emails must not offer
     * them a link to /member/orders — it would only bounce them to a login.
     */
    public function belongsToMember(): bool
    {
        return $this->user_id !== null && optional($this->user)->role === 'user';
    }

    /**
     * Move the order to the status its sub-orders agree on.
     *
     * One seller shipping their own parcel doesn't make the whole order shipped,
     * so the order only follows once every seller has reached the same status.
     *
     * @return bool True when the order's status actually changed.
     */
    public function syncStatusFromSubOrders(): bool
    {
        $statuses = $this->subOrders()->pluck('status')->unique();

        if ($statuses->count() !== 1 || $this->status === $statuses->first()) {
            return false;
        }

        $this->status = $statuses->first();
        $this->save();

        return true;
    }
    public function vitalBoostSubscriptions()
    {
        return $this->hasMany(VitalBoostSubscription::class);
    }
    
}

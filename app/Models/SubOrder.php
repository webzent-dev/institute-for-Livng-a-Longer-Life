<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'seller_id',
        'sub_order_number',
        'subtotal',
        'shipping_method',
        'shipping_cost',
        'handling_fee',
        'tax',
        'total',
        'status',
        'payment_status',
        'origin_address',
        'destination_address',
        'tracking_number',
        'carrier',
        'service_level',
        'weight',
        'package_dimensions',
        'notes',
        'shippo_rate_id',
        'shippo_transaction_id',
        'label_url',
        'label_pdf_url',
        'label_created_at',
    ];

    protected $casts = [
        'origin_address' => 'array',
        'destination_address' => 'array',
        'package_dimensions' => 'array',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'handling_fee' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'weight' => 'decimal:2',
        'label_created_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function items()
    {
        return $this->hasMany(SubOrderItem::class);
    }

    public function generateSubOrderNumber()
    {
        $this->sub_order_number = 'SUB_' . $this->order->order_number . '_' . $this->seller_id . '_' . time();
        return $this->sub_order_number;
    }

    public function getOriginAddress()
    {
        if ($this->origin_address) {
            return $this->origin_address;
        }

        // Fallback to seller's business address
        $businessDetails = $this->seller->collaboratorBusinessDetails;
        if ($businessDetails) {
            return [
                'address_line_1' => $businessDetails->business_address,
                'city' => $businessDetails->business_city,
                'state' => $businessDetails->business_state,
                'zip_code' => $businessDetails->business_zip_code,
                'country' => $businessDetails->business_country,
            ];
        }

        return null;
    }

    public function calculateWeightAndDimensions()
    {
        $totalWeight = 0;
        $dimensions = [];

        foreach ($this->items as $item) {
            $product = $item->product;
            if ($product) {
                $totalWeight += ($product->weight ?? 0) * $item->quantity;
                
                // For simplicity, use the largest product dimensions
                if ($product->length && $product->width && $product->height) {
                    $dimensions = [
                        'length' => max($dimensions['length'] ?? 0, $product->length),
                        'width' => max($dimensions['width'] ?? 0, $product->width),
                        'height' => max($dimensions['height'] ?? 0, $product->height),
                    ];
                }
            }
        }

        $this->weight = $totalWeight;
        $this->package_dimensions = $dimensions;

        return [
            'weight' => $totalWeight,
            'dimensions' => $dimensions,
        ];
    }
}

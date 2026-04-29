<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_order_id',
        'order_item_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'total',
        'product_snapshot',
    ];

    protected $casts = [
        'product_snapshot' => 'array',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function subOrder()
    {
        return $this->belongsTo(SubOrder::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getProductSnapshot()
    {
        if ($this->product_snapshot) {
            return $this->product_snapshot;
        }

        // Create snapshot from current product data
        $product = $this->product;
        if ($product) {
            return [
                'name' => $product->name,
                'price' => $product->price,
                'originalPrice' => $product->originalPrice,
                'image' => $product->image,
                'weight' => $product->weight,
                'length' => $product->length,
                'width' => $product->width,
                'height' => $product->height,
            ];
        }

        return null;
    }
}

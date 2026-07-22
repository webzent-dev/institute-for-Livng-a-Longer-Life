<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'sku',
        'product_type',        
        'name',
        'slug',
        'description',
        'price',
        'discount',
        'originalPrice',
        'category',
        'rating',
        'reviews',
        'stock_quantity',
        'image',
        'pdf_file',
        'status',
        'weight',
        'length',
        'width',
        'height',
        'shipping_template',
        'requires_shipping',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Absolute path to the uploaded guide PDF, or null when there is no file on
     * disk. Guide PDFs live outside the public folder (storage/app/product_pdfs)
     * so paid downloads can only be reached through a gated controller action.
     */
    public function pdfPath(): ?string
    {
        if (empty($this->pdf_file)) {
            return null;
        }

        $path = storage_path('app/product_pdfs/' . $this->pdf_file);

        return file_exists($path) ? $path : null;
    }
}
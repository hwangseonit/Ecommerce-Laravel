<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_name',
        'price',
        'image_url',
        'stock',
        'status',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function attributes()
    {
        return $this->hasMany(VariantAttribute::class, 'variant_id');
    }

    public function getFinalPriceAttribute()
    {
        $discount = $this->product->discounts()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if ($discount) {
            if ($discount->discount_percentage) {
                return $this->price * (1 - $discount->discount_percentage / 100);
            } elseif ($discount->discount_amount) {
                return $this->price - $discount->discount_amount;
            }
        }

        return $this->price;
    }
}

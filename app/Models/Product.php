<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_description',
        'long_description',
        'specifications',
        'is_hot',
        'is_most_viewed',
        'status',
        'has_variants',
        'base_price',
        'image_url',
        'sub_images_urls',
        'store_quantity',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function getFinalPriceAttribute()
    {
        $discount = $this->discounts()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if ($discount) {
            if ($discount->discount_percentage) {
                return $this->base_price * (1 - $discount->discount_percentage / 100);
            } elseif ($discount->discount_amount) {
                return $this->base_price - $discount->discount_amount;
            }
        }

        return $this->base_price;
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}

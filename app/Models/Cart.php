<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public static function totalItems()
    {
        $cart = self::where('user_id', auth()->id())->where('status', 'active')->first();
        return $cart ? $cart->items->sum('quantity') : 0;
    }

    public static function getCartItems()
    {
        $cart = self::where('user_id', auth()->id())->where('status', 'active')->first();
        return $cart ? $cart->items : collect();
    }
}

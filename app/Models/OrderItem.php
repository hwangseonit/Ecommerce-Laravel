<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'variant_id', 'product_name', 'quantity', 'price', 'total_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public static function bestSellingProducts($startDate, $endDate, $limit = 5)
    {
        return self::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function slowestSellingProducts($startDate, $endDate, $limit = 5)
    {
        return self::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'asc')
            ->limit($limit)
            ->get();
    }
}

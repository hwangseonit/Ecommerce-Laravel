<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_code',  'full_name', 'phone', 'city', 'district', 'ward', 'address', 'note', 'total_amount', 'discount_amount', 'final_amount', 'voucher_code', 'payment_method', 'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function newCustomers($startDate, $endDate)
    {
        return self::whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('user', function ($query) use ($startDate) {
                $query->whereDoesntHave('orders', function ($query) use ($startDate) {
                    $query->where('created_at', '<', $startDate);
                });
            })
            ->count();
    }

    public static function returningCustomers($startDate, $endDate)
    {
        return self::whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('user', function ($query) use ($startDate) {
                $query->whereHas('orders', function ($query) use ($startDate) {
                    $query->where('created_at', '<', $startDate);
                });
            })
            ->count();
    }
}

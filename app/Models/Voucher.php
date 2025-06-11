<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'start_date', 'end_date', 'quantity', 'used', 'discount_percentage', 'max_discount_amount'
    ];

    public function isValid()
    {
        return $this->quantity > $this->used && now()->between($this->start_date, $this->end_date);
    }

    public function applyDiscount($totalAmount)
    {
        $discountAmount = ($totalAmount * $this->discount_percentage) / 100;
        return min($discountAmount, $this->max_discount_amount);
    }
}

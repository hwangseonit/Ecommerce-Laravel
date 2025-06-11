<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_id',
       
    ];

   

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
    public function variantAttributes()
    {
        return $this->hasMany(VariantAttribute::class, 'attribute_id', 'attribute_id');
    }
}

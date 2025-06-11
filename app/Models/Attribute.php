<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_name',
    ];
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
    public function variantAttributes()
    {
        return $this->hasMany(VariantAttribute::class);
    }
}

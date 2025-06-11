<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $fillable = ['name', 'parent_id', 'slug', 'status'];

    public function parent()
    {
        return $this->belongsTo(Menus::class, 'parent_id');
    }
}

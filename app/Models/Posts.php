<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'slug', 
        'user_id',
        'post_category_id',
        'content',
        'description',
        'image',
        'status',
    ];
    public function author()
    {

        return $this->belongsTo(User::class, 'user_id');
    }

    // Định nghĩa mối quan hệ với PostCategory
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
}

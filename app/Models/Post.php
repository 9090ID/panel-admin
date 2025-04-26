<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = [
        'title', 'content', 'image', 'author', 'slug', 'views'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class); // Relasi satu ke banyak
    }
}
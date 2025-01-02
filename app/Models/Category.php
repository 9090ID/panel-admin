<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post');
    }
    // public function pengumuman()
    // {
    //     return $this->belongsToMany(Pengumuman::class, 'pengumuman_category');
    // }
    public function pengumumans()
    {
        return $this->belongsToMany(Pengumuman::class,'pengumuman_category');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumen';

    protected $fillable = [
        'judul',
        'author',
        'isipengumuman',
        'file',
        'tanggalpublish',
        'slug',
        'status',

    ];

    // Relasi dengan kategori
    // public function kategori()
    // {
    //     return $this->belongsTo(Category::class, 'kategoripengumuman_id');
    // }
    public function categories()
    {
        return $this->belongsToMany(Category::class,'pengumuman_category');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Tentukan kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'comment',
        'post_id',
    ];

    /**
     * Relasi dengan model Post
     * Setiap komentar milik satu post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class); // Relasi banyak ke satu
    }
}

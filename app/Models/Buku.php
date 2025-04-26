<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
   
    protected $table = 'buku';
    protected $primaryKey = 'id'; // Default is 'id'

    // Menambahkan file_buku ke fillable
    protected $fillable = [
        'judul', 'penulis', 'penerbit', 'tahun_terbit', 'deskripsi', 'file_buku','status','slug'
    ];
}

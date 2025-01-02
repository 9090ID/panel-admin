<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'mahasiswa';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama',
        'nim',
        'prodi_id',
        'no_hp',
        'alamat',
        'tanggal_lahir',
        'angkatan',
        'email',
        'foto',
    ];

    /**
     * Relasi Mahasiswa dengan Prodi (Many-to-One)
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
    // public static function deleteall()
    // {
    //     return self::truncate();  // Menghapus semua data di tabel mahasiswa
    // }
}

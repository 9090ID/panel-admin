<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $fillable = [
        'namaprodi', 'kodeprodi', 'jenjang','akreditasi', 'visi', 'misi', 'deskripsisingkat', 'ketua_prodi_id', 'fakultas_id'
    ];

    // Relasi ke Fakultas
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class); // Asumsi ada relasi ke model Fakultas
    }

    // Relasi ke Pegawai (Ketua Prodi)
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'ketua_prodi_id'); // Menggunakan ketua_prodi_id sebagai foreign key
    }
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}

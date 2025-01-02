<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'namadekan', 'nip', 'jabatan_id', 'fotodekan', 'lulusanterakhir'
    ];
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function fakultas()
    {
        return $this->hasOne(Fakultas::class, 'dekan_id');
    }
    public function prodis()
    {
        return $this->hasMany(Prodi::class, 'ketua_prodi_id');
    }
    public function periodeJabatan()
    {
        return $this->hasOne(PeriodeJabatan::class);
    }
    public function sambutanPejabat()
{
    return $this->hasOne(SambutanPejabat::class);
}
}

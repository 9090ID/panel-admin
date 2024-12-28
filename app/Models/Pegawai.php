<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'namadekan', 'nip', 'jabatan', 'fotodekan', 'lulusanterakhir'
    ];

    public function fakultas()
    {
        return $this->hasOne(Fakultas::class, 'dekan_id');
    }
}

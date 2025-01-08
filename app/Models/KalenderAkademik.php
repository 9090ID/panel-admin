<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    use HasFactory;


    protected $table = 'kalender_akademik'; // Nama tabel jika berbeda dengan konvensi

    protected $fillable = [
        'tahun_akademik_id',
        'nama_event',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }
}

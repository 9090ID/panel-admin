<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    use HasFactory;
    protected $table = 'tahun_akademik';
    protected $fillable = [
        'nama_tahun',
        'semester',
        'aktif',
    ];
    public function kalenderAkademik()
    {
        return $this->hasMany(KalenderAkademik::class, 'tahun_akademik_id');
    }
}

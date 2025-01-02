<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SambutanPejabat extends Model
{
    use HasFactory;
    protected $table = 'sambutan_pejabat';
    protected $fillable = [
        'pegawai_id',
        'jabatan_id',
        'isisambutan',
        'riwayathidup',
        'tglmulaimenjabat',
        'akhirjabatan',
        'fotopejabat',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function getTotalMenjabatAttribute()
    {
        $start = \Carbon\Carbon::parse($this->tglmulaimenjabat);
        $end = \Carbon\Carbon::parse($this->akhirjabatan);
        $duration = $start->diff($end);

        return "{$duration->y} Tahun {$duration->m} Bulan {$duration->d} Hari";
    }
}

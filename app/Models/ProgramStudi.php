<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_program_studi', 
        'deskripsi', 
        'akreditasi', 
        'fakultas_id', 
        'pegawai_id'
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}

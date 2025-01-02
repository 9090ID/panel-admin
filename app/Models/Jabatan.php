<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $fillable = ['namajabatan', 'status'];
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'jabatan_id');
    }
    public function jabatan()
{
    return $this->belongsTo(Jabatan::class, 'jabatan_id');
}
}

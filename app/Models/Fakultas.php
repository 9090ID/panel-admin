<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Fakultas extends Model
{
    use HasFactory;
    protected $fillable = [
        'namafakultas', 'visi', 'misi', 'deskripsi_singkat', 'fotofakultas', 'akreditasi', 'slug', 'dekan_id'
    ];

    public function dekan()
    {
        return $this->belongsTo(Pegawai::class, 'dekan_id');
    }

    // Menggenerate slug otomatis
    public static function boot()
    {
        parent::boot();

        static::creating(function ($fakultas) {
            $fakultas->slug = Str::slug($fakultas->namafakultas, '-');
        });
    }
}

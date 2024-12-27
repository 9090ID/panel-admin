<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;
    protected $fillable = [
         'name', 'description', 'history', 'vision', 'mission', 
    'founded_year', 'structure_image', 'logo'
    ];
}

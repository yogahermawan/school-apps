<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'level_id',
        'kelas_category_id',
        'siswa_id',
        'school_year_id'
    ];
}

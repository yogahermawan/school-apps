<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date_of_birth',
        'place_of_birth',
        'mother_name',
        'father_name',
        'gender',
        'nis'
    ];

    public function listLevel()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
    public function kelas()
    {
        return $this->hasMany(SiswaKelas::class, 'kelas_id');
    }
    public function kelasCategory()
    {
        return $this->hasMany(SiswaKelas::class, 'kelas_category_id');
    }
    public function level()
    {
        return $this->hasMany(SiswaKelas::class, 'level_id');
    }
    public function siswa()
    {
        return $this->hasMany(SiswaKelas::class, 'siswa_id');
    }
    public function schoolYear()
    {
        return $this->hasMany(SiswaKelas::class, 'school_year_id');
    }
}

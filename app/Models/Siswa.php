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

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'siswa_kelas');
    }

    public function schoolYears()
    {
        return $this->belongsToMany(SchoolYear::class, 'siswa_kelas');
    }

    public function classes()
    {
        return $this->belongsToMany(Kelas::class, 'siswa_kelas');
    }

    public function classCategories()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_categories');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;

    protected $fillable = [
        "start_year",
        "end_year"
        // "school_year_id",
        // "kelas_id",
        // "spp",
        // "dsp",
        // "kegiatan_akhir_tahun",
        // "uang_buku"
    ];

    public function classes()
    {
        return $this->hasMany(Kelas::class);
    }
}

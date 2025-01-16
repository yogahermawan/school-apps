<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'kelas_id'
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'kelas_id');
    }
}

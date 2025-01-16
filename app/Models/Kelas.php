<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'level_id'];

    public function level()
    {
        return $this->hasMany(Level::class, 'id');
    }

    public function categories()
    {
        return $this->hasMany(KelasCategory::class, 'kelas_id');
    }
}

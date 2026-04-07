<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jugador extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'posicion', 'dorsal', 'club_id'];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}

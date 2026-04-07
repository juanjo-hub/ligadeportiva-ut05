<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'ciudad', 'categoria'];

    public function jugadors()
    {
        return $this->hasMany(Jugador::class);
    }
}

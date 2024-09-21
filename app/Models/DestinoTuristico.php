<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoTuristico extends Model
{
    use HasFactory;

    public function pacotesViagem()
    {
        return $this->belongsToMany(PacoteViagem::class, 'destino_turistico_pacote_viagem');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgenteViagem extends Model
{
    use HasFactory;

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PacoteViagem extends Model
{
    use HasFactory;

    public function tipoPacote(): BelongsTo
    {
        return $this->belongsTo(TipoPacote::class);
    }

    public function hoteis(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'hotel_pacote_viagem');
    }

    public function destinosTuristicos(): BelongsToMany
    {
        return $this->belongsToMany(DestinoTuristico::class, 'destino_turistico_pacote_viagem');
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}

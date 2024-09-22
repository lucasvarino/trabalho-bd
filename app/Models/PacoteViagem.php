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

    protected $table = 'pacoteviagem';
    public $timestamps = false;
    protected $guarded = [];

    public function tipoPacote(): BelongsTo
    {
        return $this->belongsTo(TipoPacote::class, 'tipopacoteid');
    }

    public function hoteis(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'hotelpacoteviagem', 'pacoteviagemid', 'hotelid');
    }

    public function destinosTuristicos(): BelongsToMany
    {
        return $this->belongsToMany(DestinoTuristico::class, 'destinoturisticopacoteviagem', 'pacoteviagemid', 'destinoturisticoid');
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'pacoteviagemid');
    }
}

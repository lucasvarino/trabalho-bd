<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvaliacaoCliente extends Model
{
    use HasFactory;

    protected $table = 'avaliacaocliente';
    public $timestamps = false;
    protected $guarded = [];

    public function reserva(): BelongsTo
    {
        return $this->belongsTo(Reserva::class, 'reservaid');
    }

    public function cliente()
    {
        return $this->hasOneThrough(Cliente::class,
            Reserva::class,
            'id',
            'id',
            'reservaid',
            'clienteid'
        );
    }
}

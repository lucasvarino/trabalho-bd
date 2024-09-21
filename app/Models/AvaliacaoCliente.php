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

    public function reserva(): BelongsTo
    {
        return $this->belongsTo(Reserva::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reserva extends Model
{
    use HasFactory;

    public function pagamento()
    {
        return $this->hasOne(Pagamento::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pacoteViagem(): HasOne
    {
        return $this->hasOne(PacoteViagem::class);
    }

    public function avaliacaoCliente(): HasOne
    {
        return $this->hasOne(AvaliacaoCliente::class);
    }

    public function servicosAdicionais(): BelongsToMany
    {
        return $this->belongsToMany(ServicoAdicional::class, 'reserva_servico_adicional');
    }

    public function agenteViagem(): BelongsTo
    {
        return $this->belongsTo(AgenteViagem::class);
    }


}

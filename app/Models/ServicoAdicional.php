<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoAdicional extends Model
{
    use HasFactory;

    public function academia()
    {
        return $this->hasOne(Academia::class);
    }

    public function aluguelCarro()
    {
        return $this->hasOne(AluguelCarro::class);
    }

    public function voo()
    {
        return $this->hasOne(Voo::class);
    }

    public function passeio()
    {
        return $this->hasOne(Passeio::class);
    }

    public function reservas()
    {
        return $this->belongsToMany(Reserva::class, 'reserva_servico_adicional');
    }
}

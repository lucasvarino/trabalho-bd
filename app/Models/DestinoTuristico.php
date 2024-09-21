<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoTuristico extends Model
{
    use HasFactory;

    protected $table = 'destinoturistico';
    public $timestamps = false;

    public function pacotesViagem()
    {
        return $this->belongsToMany(PacoteViagem::class, 'destinoturisticopacoteviagem', 'destinoturisticoid', 'pacoteviagemid');
    }
}

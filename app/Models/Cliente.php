<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    public $timestamps = false;

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}

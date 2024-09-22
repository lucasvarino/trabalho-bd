<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgenteViagem extends Model
{
    use HasFactory;

    protected $table = 'agenteviagem';
    public $timestamps = false;
    public $guarded = [];

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}

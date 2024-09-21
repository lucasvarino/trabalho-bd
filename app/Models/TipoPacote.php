<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPacote extends Model
{
    use HasFactory;

    public function pacotesViagem()
    {
        return $this->hasMany(PacoteViagem::class);
    }
}

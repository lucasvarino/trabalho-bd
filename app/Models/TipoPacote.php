<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPacote extends Model
{
    use HasFactory;

    protected $table = 'tipopacote';
    public $timestamps = false;

    public function pacotesViagem()
    {
        return $this->hasMany(PacoteViagem::class);
    }
}

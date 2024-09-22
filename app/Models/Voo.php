<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voo extends Model
{
    use HasFactory;

    protected $table = 'voo';
    public $timestamps = false;
    protected $guarded = [];

    public function servicoAdicional(): BelongsTo
    {
        return $this->belongsTo(ServicoAdicional::class, 'id');
    }

    public function companhiaAerea(): BelongsTo
    {
        return $this->belongsTo(CompanhiaAerea::class, 'companhiaaereaid');
    }
}

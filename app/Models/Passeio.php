<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Passeio extends Model
{
    use HasFactory;

    protected $table = 'passeio';
    public $timestamps = false;

    public function servicoAdicional(): BelongsTo
    {
        return $this->belongsTo(ServicoAdicional::class);
    }
}

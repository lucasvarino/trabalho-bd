<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Academia extends Model
{
    use HasFactory;

    public function servicoAdicional(): BelongsTo
    {
        return $this->belongsTo(ServicoAdicional::class);
    }
}

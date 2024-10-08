<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'pagamento';
    public $timestamps = false;
    protected $guarded = [];

    public function reserva(): BelongsTo
    {
        return $this->belongsTo(Reserva::class);
    }
}

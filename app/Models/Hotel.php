<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotel';
    public $timestamps = false;

    public function pacotesViagem(): BelongsToMany
    {
        return $this->belongsToMany(PacoteViagem::class, 'hotelpacoteviagem', 'hotelid', 'pacoteviagemid');
    }
}

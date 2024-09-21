<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanhiaAerea extends Model
{
    use HasFactory;

    protected $table = 'companhiaaerea';
    public $timestamps = false;

    public function voos()
    {
        return $this->hasMany(Voo::class);
    }
}

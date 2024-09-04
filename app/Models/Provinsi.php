<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsis';

    protected $guarded = [];

    public function panen()
    {
        return $this->hasMany(panen::class, 'id_provinsi', 'id');
    }
}

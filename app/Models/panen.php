<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class panen extends Model
{
    use HasFactory;

    protected $table = 'panens';

    protected $guarded = [];

    public function petani()
    {
        return $this->belongsTo(User::class, 'id_petani', 'id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi', 'id');
    }
}

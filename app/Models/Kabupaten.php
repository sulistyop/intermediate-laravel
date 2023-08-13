<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = "dc_kabupaten";
    protected $fillable = [];

    public function provinsi(): HasOne
    {
        return $this->hasOne(Provinsi::class, 'id','id_provinsi');
    }
}

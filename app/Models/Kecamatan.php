<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = "dc_kecamatan";
    protected $fillable = [];

    public function kabupaten(): HasOne
    {
        return $this->hasOne(Kabupaten::class,'id','id_kabupaten');
    }
}

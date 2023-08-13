<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;
    protected $table = "dc_pasien";
    protected $fillable = [
        'id','nama','id_kelurahan'
    ];
    protected $hidden = ['id'];
    protected $primaryKey = "id";
    protected $keyType = "string";
    public function kelurahan()
    {
        return $this->hasOne(Kelurahan::class,'id','id_kelurahan');
    }



}

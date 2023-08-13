<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = "dc_kelurahan";
    protected $fillable = [];
    protected $hidden = ['id'];

    public function kecamatan()
    {
        return $this->hasOne(Kecamatan::class, 'id','id_kecamatan');
    }
}

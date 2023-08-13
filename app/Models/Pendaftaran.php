<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendaftaran extends Model
{
    use HasFactory;
//    protected $primaryKey = 'id';

    protected $table = "dc_pendaftaran";
    protected $fillable = [
        'id',
        'no_register',
        'id_pasien',
        'waktu_daftar',
        'waktu_keluar',
        'jenis',
        'jenis_igd',
        'status',
        'langsung'
    ];

    public function pasien()
    {
        return $this->hasOne(Pasien::class,'id','id_pasien');
    }
}

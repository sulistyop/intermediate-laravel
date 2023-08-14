<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('no_register',15)->index()->nullable();
            $table->integer('id_pasien')->index()->nullable();
            $table->date('waktu_daftar')->index()->nullable();
            $table->date('waktu_keluar')->index()->nullable();
            $table->enum('jenis',['IGD','Poliklinik'])->default('IGD');
            $table->enum('jenis_igd',['Umum','Kamar Bersalin'])->default('Umum');
            $table->enum('status',['Baru','Lama','Batal','Booking'])->default('Baru');
            $table->enum('langsung',['Ya','Tidak'])->default('Ya');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_pendaftaran');
    }
};

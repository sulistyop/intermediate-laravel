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
        Schema::create('dc_kabupaten', function (Blueprint $table) {
            $table->id();
            $table->string('nama',50)->index()->nullable();
            $table->integer('id_provinsi')->index()->nullable();
            $table->string('kode',10)->index()->nullable();
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
        Schema::dropIfExists('dc_kabupaten');
    }
};

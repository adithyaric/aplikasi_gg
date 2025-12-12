<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingPagesTable extends Migration
{
    public function up()
    {
        Schema::create('setting_pages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sppg')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('nama_sppi')->nullable();
            $table->string('ahli_gizi')->nullable();
            $table->string('akuntan_sppg')->nullable();
            $table->string('asisten_lapangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('setting_pages');
    }
}

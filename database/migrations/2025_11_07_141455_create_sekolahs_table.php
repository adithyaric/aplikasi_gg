<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSekolahsTable extends Migration
{
    public function up()
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('nama_pic')->nullable();
            $table->string('nomor')->nullable();
            $table->string('jarak')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sekolahs');
    }
}

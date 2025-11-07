<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('noreg');
            $table->string('name');
            $table->string('nik');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('jk');
            $table->string('agama');
            $table->string('warganegara');
            $table->string('pekerjaan');
            $table->string('alamat');
            $table->string('no_telp');
            $table->foreignId('category_id');
            $table->dateTime('tgl_kejadian');
            $table->longText('desc');
            $table->foreignId('ttd_id');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('surats');
    }
}

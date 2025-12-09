<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->enum('status', ['hadir', 'tidak_hadir'])->default('hadir');
            $table->boolean('confirmed')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensis');
    }
}

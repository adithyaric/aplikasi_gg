<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriKaryawansTable extends Migration
{
    public function up()
    {
        Schema::create('kategori_karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->bigInteger('nominal_gaji')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('karyawan_kategori_karyawan', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('kategori_karyawan_id')->constrained()->onDelete('cascade');
        //     $table->timestamps();
        // });
        Schema::table('karyawans', function (Blueprint $table) {
            $table->foreignId('kategori_karyawan_id')->nullable()->after('id')->constrained('kategori_karyawans')->onDelete('set null');
        });
    }

    public function down()
    {
        // Schema::dropIfExists('karyawan_kategori_karyawan');
        Schema::dropIfExists('kategori_karyawans');
    }
}

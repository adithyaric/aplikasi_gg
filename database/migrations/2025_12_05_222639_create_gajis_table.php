<?php

use App\Models\RekeningRekapBKU;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGajisTable extends Migration
{
    public function up()
    {
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->integer('rekening_rekap_bku_id')->nullable();
            $table->foreignId('karyawan_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('periode_bulan')->nullable();
            $table->integer('periode_tahun')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_akhir')->nullable();
            $table->integer('jumlah_hadir')->nullable();
            $table->integer('nominal_per_hari')->nullable();
            $table->integer('total_gaji')->nullable();
            $table->enum('status', ['hold', 'confirm'])->default('hold');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gajis');
    }
}

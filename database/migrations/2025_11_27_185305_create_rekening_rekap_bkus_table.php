<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningRekapBKUSTable extends Migration
{
    public function up()
    {
        Schema::create('rekening_rekap_bku', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_transaksi')->nullable();
            $table->string('no_bukti')->nullable();
            $table->string('link_bukti')->nullable();
            $table->string('jenis_bahan')->nullable();
            $table->string('nama_bahan')->nullable();
            $table->integer('kuantitas')->default(1)->nullable();
            $table->string('satuan')->nullable();
            $table->string('supplier')->nullable();
            $table->text('uraian')->nullable();
            $table->decimal('debit', 15, 2)->default(0)->nullable();
            $table->decimal('kredit', 15, 2)->default(0)->nullable();
            $table->decimal('saldo', 15, 2)->nullable();
            $table->integer('bulan')->nullable();
            $table->integer('minggu')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekening_rekap_bku');
    }
}

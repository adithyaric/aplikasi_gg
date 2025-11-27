<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningKoranVasTable extends Migration
{
    public function up()
    {
        Schema::create('rekening_koran_vas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_transaksi')->nullable();
            $table->string('ref')->nullable();
            $table->text('uraian')->nullable();
            $table->decimal('debit', 15, 2)->default(0)->nullable();
            $table->decimal('kredit', 15, 2)->default(0)->nullable();
            $table->decimal('saldo', 15, 2)->default(0)->nullable();
            $table->string('kategori_transaksi')->nullable();
            $table->integer('minggu')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekening_koran_vas');
    }
}

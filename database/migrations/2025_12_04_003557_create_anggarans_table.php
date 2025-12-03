<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggaransTable extends Migration
{
    public function up()
    {
        Schema::create('anggarans', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('sekolah_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('porsi_8k')->nullable()->default(0);
            $table->integer('porsi_10k')->nullable()->default(0);
            $table->integer('total_porsi')->nullable()->default(0);
            $table->decimal('budget_porsi_8k', 15, 2)->nullable()->default(0);
            $table->decimal('budget_porsi_10k', 15, 2)->nullable()->default(0);
            $table->decimal('budget_operasional', 15, 2)->nullable()->default(0);
            $table->decimal('budget_sewa', 15, 2)->nullable()->default(0);
            $table->enum('aturan_sewa', ['aturan_1', 'aturan_2'])->nullable()->default('aturan_1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggarans');
    }
}

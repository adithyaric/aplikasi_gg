<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockAdjustmentsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->date('adjustment_date');
            $table->foreignId('bahan_baku_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('bahan_operasional_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('quantity', 15, 2)->nullable()->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_adjustments');
    }
}

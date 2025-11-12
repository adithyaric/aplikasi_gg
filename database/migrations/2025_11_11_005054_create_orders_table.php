<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->nullable();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_po')->nullable();
            $table->date('tanggal_penerimaan')->nullable();
            $table->decimal('grand_total', 15, 2)->nullable()->default(0);
            $table->string('status')->nullable()->default('draft'); //'draft', 'confirmed'
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('bahan_baku_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 10, 2)->nullable()->default(0);
            $table->string('satuan')->nullable();
            $table->decimal('unit_cost', 15, 2)->nullable()->default(0);
            $table->decimal('subtotal', 15, 2)->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();
            $table->decimal('amount', 15, 2)->nullable()->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
}

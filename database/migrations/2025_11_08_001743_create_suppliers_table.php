<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('bank_no_rek')->nullable();
            $table->string('bank_nama')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->text('alamat')->nullable();
            $table->text('products')->nullable(); // json/arrays???
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}

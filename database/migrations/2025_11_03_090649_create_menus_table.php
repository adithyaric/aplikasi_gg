<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_menu_id')->constrained()->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('bahan_baku_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('bahan_baku_id')->constrained()->onDelete('cascade');
            $table->decimal('berat_bersih', 10, 2);
            $table->decimal('energi', 10, 2);
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
        Schema::dropIfExists('bahan_baku_menu');
        Schema::dropIfExists('menus');
    }
}

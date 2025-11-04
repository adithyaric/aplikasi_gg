<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRencanaMenusTable extends Migration
{
    public function up()
    {
        Schema::create('rencana_menus', function (Blueprint $table) {
            $table->id();
            $table->string('periode')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rencana_paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rencana_menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('paket_menu_id')->constrained()->onDelete('cascade');
            $table->bigInteger('porsi')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rencana_menus');
    }
}

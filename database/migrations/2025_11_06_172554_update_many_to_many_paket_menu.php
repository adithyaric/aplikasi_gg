<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateManyToManyPaketMenu extends Migration
{
    public function up()
    {
        // Create pivot table for PaketMenu and Menu
        Schema::create('menu_paket_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Remove paket_menu_id from menus table
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['paket_menu_id']);
            $table->dropColumn('paket_menu_id');
        });
    }

    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->foreignId('paket_menu_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::dropIfExists('menu_paket_menu');
    }
}

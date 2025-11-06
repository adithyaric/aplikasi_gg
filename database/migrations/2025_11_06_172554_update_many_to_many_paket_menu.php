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

        Schema::table('bahan_baku_menu', function (Blueprint $table) {
            $table->foreignId('paket_menu_id')->after('id')->constrained()->onDelete('cascade');
            $table->unique(['paket_menu_id', 'menu_id', 'bahan_baku_id'], 'unique_paket_menu_bahan');
        });

        // Store menu-bahan relationship without weight/energy (just template)
        Schema::create('menu_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('bahan_baku_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['menu_id', 'bahan_baku_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_bahan_baku');

        Schema::table('bahan_baku_menu', function (Blueprint $table) {
            $table->dropUnique('unique_paket_menu_bahan');
            $table->dropForeign(['paket_menu_id']);
            $table->dropColumn('paket_menu_id');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->foreignId('paket_menu_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::dropIfExists('menu_paket_menu');
    }
}

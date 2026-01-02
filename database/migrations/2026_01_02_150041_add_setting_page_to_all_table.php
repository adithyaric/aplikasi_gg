<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSettingPageToAllTable extends Migration
{
    public function up()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('anggarans', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('bahan_operasionals', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('gajis', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('gizis', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('karyawans', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('kategori_karyawans', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('paket_menus', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('rekening_koran_vas', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('rekening_rekap_bku', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('rencana_menus', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('sekolahs', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('stock_adjustments', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->foreignId('setting_page_id')->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('setting_pages', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('anggarans', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('bahan_operasionals', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('gajis', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('gizis', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('kategori_karyawans', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('paket_menus', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('rekening_koran_vas', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('rekening_rekap_bku', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('rencana_menus', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('sekolahs', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('stock_adjustments', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['setting_page_id']);
            $table->dropColumn('setting_page_id');
            $table->dropColumn('deleted_at');
        });
        Schema::table('setting_pages', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}

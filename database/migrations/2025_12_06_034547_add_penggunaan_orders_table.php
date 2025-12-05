<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenggunaanOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status_penggunaan')->nullable()->after('status_penerimaan'); // draft, confirmed
            $table->date('tanggal_penggunaan')->nullable()->after('tanggal_penerimaan');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->float('quantity_penggunaan')->nullable()->after('quantity_diterima');
            $table->string('penggunaan_input_type')->nullable()->after('quantity_penggunaan'); // 'habis' or 'sisa'
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status_penggunaan');
            $table->dropColumn('tanggal_penggunaan');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('quantity_penggunaan');
            $table->dropColumn('penggunaan_input_type');
        });
    }
}

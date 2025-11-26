<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGovePriceBahanBakuBahanOperasionalTable extends Migration
{
    public function up()
    {
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->bigInteger('gov_price')->nullable()->after('merek')->default(0);
        });
        Schema::table('bahan_operasionals', function (Blueprint $table) {
            $table->bigInteger('gov_price')->nullable()->after('merek')->default(0);
        });
    }

    public function down()
    {
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->dropColumn('gov_price');
        });
        Schema::table('bahan_operasionals', function (Blueprint $table) {
            $table->dropColumn('gov_price');
        });
    }
}

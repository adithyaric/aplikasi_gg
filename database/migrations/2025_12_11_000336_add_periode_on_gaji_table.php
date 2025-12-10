<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPeriodeOnGajiTable extends Migration
{
    public function up()
    {
        Schema::table('gajis', function (Blueprint $table) {
            $table->string('periode')->nullable()->after('karyawan_id');
            $table->integer('periode_minggu')->nullable()->after('periode');
        });
    }

    public function down()
    {
        Schema::table('gajis', function (Blueprint $table) {
            $table->dropColumn('periode');
            $table->dropColumn('periode_minggu');
        });
    }
}

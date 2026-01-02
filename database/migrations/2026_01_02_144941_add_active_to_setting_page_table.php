<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveToSettingPageTable extends Migration
{
    public function up()
    {
        Schema::table('setting_pages', function (Blueprint $table) {
            $table->boolean('active')->default(false)->nullable()->after('asisten_lapangan');
        });
    }

    public function down()
    {
        Schema::table('setting_pages', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}

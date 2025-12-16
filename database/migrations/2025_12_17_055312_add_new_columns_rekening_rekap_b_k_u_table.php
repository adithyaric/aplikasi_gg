<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsRekeningRekapBKUTable extends Migration
{
    public function up()
    {
        Schema::table('rekening_rekap_bku', function (Blueprint $table) {
            $table->string('jenis_buku_pembantu')->nullable()->after('minggu');
            $table->string('sumber_dana')->nullable()->after('jenis_buku_pembantu');
        });
    }

    public function down()
    {
        Schema::table('rekening_rekap_bku', function (Blueprint $table) {
            $table->dropColumn('sumber_dana');
            $table->dropColumn('jenis_buku_pembantu');
        });
    }
}

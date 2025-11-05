<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGizisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gizis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_baku_id')->constrained()->onDelete('cascade');
            $table->string('nomor_pangan');
            // $table->string('rincian_bahan_makanan');
            $table->decimal('bdd', 8, 2)->default(0)->nullable();
            $table->decimal('air', 8, 2)->default(0)->nullable();
            $table->decimal('energi', 8, 2)->default(0)->nullable();
            $table->decimal('protein', 8, 2)->default(0)->nullable();
            $table->decimal('lemak', 8, 2)->default(0)->nullable();
            $table->decimal('karbohidrat', 8, 2)->default(0)->nullable();
            $table->decimal('serat', 8, 2)->default(0)->nullable();
            $table->decimal('abu', 8, 2)->default(0)->nullable();
            $table->decimal('kalsium', 8, 2)->default(0)->nullable();
            $table->decimal('fosfor', 8, 2)->default(0)->nullable();
            $table->decimal('koles', 8, 2)->default(0)->nullable();
            $table->decimal('besi', 8, 2)->default(0)->nullable();
            $table->decimal('natrium', 8, 2)->default(0)->nullable();
            $table->decimal('kalium', 8, 2)->default(0)->nullable();
            $table->decimal('tembaga', 8, 2)->default(0)->nullable();
            $table->decimal('retinol', 8, 2)->default(0)->nullable();
            $table->decimal('b_kar', 8, 2)->default(0)->nullable();
            $table->decimal('kar_total', 8, 2)->default(0)->nullable();
            $table->decimal('thiamin', 8, 2)->default(0)->nullable();
            $table->decimal('riboflavin', 8, 2)->default(0)->nullable();
            $table->decimal('niasin', 8, 2)->default(0)->nullable();
            $table->decimal('vitamin_c', 8, 2)->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gizis');
    }
}

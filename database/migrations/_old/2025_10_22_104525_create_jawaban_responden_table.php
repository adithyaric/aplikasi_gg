<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanRespondenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_responden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responden_id')->constrained('responden')->onDelete('cascade');
            $table->foreignId('kuesioner_id')->constrained('kuesioner')->onDelete('cascade');
            $table->text('jawaban')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_responden');
    }
}

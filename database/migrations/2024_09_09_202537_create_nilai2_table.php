<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai2', function (Blueprint $table) {
            $table->id();
            $table->integer('mitra_teladan_id');
            $table->integer('team_penilai_id');
            $table->integer('aspek1');
            $table->integer('aspek2');
            $table->integer('aspek3');
            $table->integer('aspek4');
            $table->integer('aspek5');
            $table->integer('aspek6');
            $table->integer('aspek7');
            $table->integer('aspek8');
            $table->integer('aspek9');
            $table->integer('aspek10');
            $table->integer('rerata');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai2');
    }
};

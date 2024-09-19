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
        Schema::create('mitrateladan', function (Blueprint $table) {
            $table->id();
            $table->string('id_sobat', 200);
            $table->string('tim', 50);
            $table->integer('nilai_tahap1');
            $table->integer('nilai_tahap2');
            $table->integer('tahun');
            $table->string('periode', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitrateladan');
    }
};

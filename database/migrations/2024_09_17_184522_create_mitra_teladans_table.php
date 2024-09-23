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
        Schema::create('mitra_teladans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mitra_id');
            $table->foreign('mitra_id')->references('id_sobat')->on('mitras')->onDelete('cascade');
            $table->foreignId('team_id')->constrained();
            $table->year('year');
            $table->integer('quarter');
            $table->decimal('avg_rating_1', 3 ,2)->nullable();
            $table->decimal('avg_rating_2', 3 ,2)->nullable();
            $table->integer('surveys_count');
            $table->boolean('status_phase_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra_teladans');
    }
};

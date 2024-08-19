<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('mitras', function (Blueprint $table) {
        $table->id('mitra_id');
        $table->unsignedBigInteger('user_id');
        $table->string('name', 200);
        $table->string('pendidikan', 50);
        $table->string('jenis_kelamin', 50);
        $table->integer('umur');
        $table->timestamps();

        $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};

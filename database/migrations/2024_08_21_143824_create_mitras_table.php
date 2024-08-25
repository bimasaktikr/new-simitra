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
        $table->id('id_sobat');
        $table->string('name', 200);
        $table->string('email', 200)->unique();
        $table->string('pendidikan', 50);
        $table->string('jenis_kelamin', 50);
        $table->integer('umur');
        $table->timestamps();

        $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
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

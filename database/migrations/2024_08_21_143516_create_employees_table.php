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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 200);
            $table->string('nip', 200);
            $table->string('jenis_kelamin', 200);
            $table->string('email', 200)->unique();
            $table->date('tanggal_lahir');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('peran', 200)->nullable();
            $table->timestamps();

            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

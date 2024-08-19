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
            $table->id('employee_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name', 200);
            $table->string('nip', 200);
            $table->unsignedBigInteger('team_id');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('team_id')->on('teams')->onDelete('cascade');
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

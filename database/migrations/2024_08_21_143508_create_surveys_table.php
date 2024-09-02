<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('surveys', function (Blueprint $table) {
        $table->id('id');
        $table->string('name', 50);
        $table->string('code', 50);
        $table->unsignedBigInteger('payment_type_id');
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('payment');
        $table->unsignedBigInteger('team_id');
        $table->string('file',255)->nullable();
        $table->timestamps();

        $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');
        $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}

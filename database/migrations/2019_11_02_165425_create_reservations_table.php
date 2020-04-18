<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_user')->foreign('id_user')->references('id')->on('users');
            $table->unsignedInteger('id_space')->foreign('id_space')->references('id')->on('spaces');
            $table->datetime('reservation_datetime');
            $table->smallInteger('total_pax');
            $table->integer('discount')->nullable();
            $table->integer('total_payment');
            $table->string('payment_status',25);
            $table->text('special_notes');
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
        Schema::dropIfExists('reservations');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_reservation', function (Blueprint $table) {
            $table->primary(['id_reservation','id_menu']);
            $table->unsignedBigInteger('id_reservation')->foreign('id_reservation')->references('id')->on('reservations');
            $table->unsignedBigInteger('id_menu')->foreign('id_menu')->references('id')->on('menus');
            $table->integer('qty');

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
        Schema::dropIfExists('detail_reservation');
    }
}

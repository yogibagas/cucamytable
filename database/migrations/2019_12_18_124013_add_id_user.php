<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challanges', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_user')->foreign('id_user')->references('id')->on('users');
            $table->tinyInteger('reservation_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challanges', function (Blueprint $table) {
            //
        });
    }
}

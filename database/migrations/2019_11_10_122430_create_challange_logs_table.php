<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challange_logs', function (Blueprint $table) {
            $table->primary(['id_user','id_challange']);
            $table->unsignedBigInteger('id_challange')->references('id')->on('challanges');
            $table->unsignedBigInteger('id_user')->references('id')->on('user');
            $table->boolean('notification_status')->default(0);
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
        Schema::dropIfExists('challange_logs');
    }
}

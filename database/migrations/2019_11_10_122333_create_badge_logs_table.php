<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badge_logs', function (Blueprint $table) {
            $table->primary(['id_user','id_badge']);
            $table->unsignedBigInteger('id_user')->foreign('id_user')->references('id')->on('users');
            $table->unsignedBigInteger('id_badge')->foreign('id_badge')->references('id')->on('badges');
            $table->text('description');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('badge_logs');
    }
}

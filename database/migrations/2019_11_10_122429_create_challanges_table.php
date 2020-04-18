<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_reward')->foreign('id_reward')->references('id')->on('rewards');
            $table->boolean('is_multiple')->default(0);
            $table->string('type',125);
            $table->double('min_transaction');
            $table->date('reservation_date')->nullable();
            $table->integer('reservation_required');
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
        Schema::dropIfExists('challanges');
    }
}

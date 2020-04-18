<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',125);
            $table->integer('price');
            $table->string('image_name');
            $table->boolean('status')->default(1);
            $table->text('desc')->nullable();
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_category')->references('id')->on('menu_categories')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}

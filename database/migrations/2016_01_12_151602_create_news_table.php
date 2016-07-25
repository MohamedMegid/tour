<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('main_image_id')->unsigned()->index()->nullable();// main image id
            $table->integer('important_news')->unsigned()->index()->default(2);//2 not important
            $table->integer('social_published')->unsigned()->index()->default(2);//2 unpublished
            $table->integer('published')->unsigned()->index()->default(2);//2 unpublished
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('news');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('main_image_id')->unsigned()->index()->nullable();// main image id
            $table->date('startdate');
            $table->date('enddate');
            $table->integer('from');
            $table->integer('to');
            $table->integer('city');
            $table->integer('area');
            $table->string('website');
            $table->integer('social_published')->unsigned()->index()->default(2);//2 unpublished
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_type')->unsigned()->index()->nullable();//1 for sites 2 for news
            $table->integer('content_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->integer('web_visits')->default(0);
            $table->integer('android_visits')->default(0);
            $table->integer('ios_visits')->default(0);
            $table->integer('total_visits')->default(0);
			$table->string('lang');
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
       Schema::drop('visits');
    }
}

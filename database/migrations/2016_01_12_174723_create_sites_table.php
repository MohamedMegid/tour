<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('main_image_id')->unsigned()->index()->nullable();// main image id
            $table->integer('site_type')->unsigned()->index()->nullable(); // 0 for services sections 1 for locations sections
            $table->integer('section_id')->unsigned()->index()->nullable(); // 0 for services sections 1 for locations sections
            $table->foreign('section_id')->references('id')->on('sections');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('created_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->unsigned()->index()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->integer('published')->unsigned()->index()->default(2);//2 unpublished
            $table->integer('important_site')->unsigned()->index()->default(2);//2 not important
            $table->integer('feature_site')->unsigned()->index()->default(2);//2 no feature
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
        Schema::drop('sites');
    }
}

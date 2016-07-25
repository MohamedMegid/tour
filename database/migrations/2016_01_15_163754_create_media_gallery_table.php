<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('media_id')->unsigned()->index()->nullable();
            $table->integer('content_type')->unsigned()->index()->nullable();
            $table->integer('content_id')->unsigned()->index()->nullable();
            $table->integer('category_id')->unsigned()->index()->nullable();
            $table->integer('is_main')->unsigned()->index()->default(0);
            $table->integer('image_order')->unsigned()->index()->default(0);
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
        Schema::drop('media_gallery');
    }
}

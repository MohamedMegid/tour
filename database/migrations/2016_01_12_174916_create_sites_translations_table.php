<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites_trans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->unsigned()->index()->nullable();
            $table->foreign('site_id')->references('id')->on('sites');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
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
        Schema::drop('sites_trans');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuburbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suburb', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->string('name',255);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suburb');
    }
}

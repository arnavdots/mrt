<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('media_name',255)->unique();
            $table->string('media_type',15);
            $table->unsignedBigInteger('task_note_id');
            $table->foreign('task_note_id')->references('id')->on('task_notes')->onUpdate('cascade');
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
        Schema::dropIfExists('task_media');
    }
}

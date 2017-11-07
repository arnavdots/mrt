<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubModulesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sub__modules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('module_id');
            $table->string('name', 50);
            $table->string('slug', 50);
            $table->string('controller', 100)->nullable();
            $table->boolean('status')->default('1');
            $table->tinyInteger('order');
            $table->timestamps();
            $table->foreign('module_id')->references('id')->on('modules')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['name', 'slug']);
            $table->index(['name', 'slug', 'controller']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sub__modules');
    }

}

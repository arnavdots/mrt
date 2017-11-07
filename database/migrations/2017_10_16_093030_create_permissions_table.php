<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('display_name', 50)->nullable;
            $table->string('controller_name', 50)->nullable;
            $table->unsignedInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules')->onUpdate('cascade');
            $table->unsignedInteger('sub_module_id');
            $table->foreign('sub_module_id')->references('id')->on('sub_modules')->onUpdate('cascade');
            $table->longText('description')->nullable;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('permissions');
    }

}

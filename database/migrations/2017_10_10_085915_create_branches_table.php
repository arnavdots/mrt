<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('branch_code',10)->nullable();
            $table->unsignedBigInteger('owner_id')->comment('user id');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->string('address_line_1',100)->nullable();
            $table->string('address_line_2',100)->nullable();
            $table->unsignedInteger('suburb_id')->nullable();
            $table->foreign('suburb_id')->references('id')->on('suburb');
            $table->unsignedInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string('postcode',10)->nullable();
            $table->boolean('is_active')->default('1');
            $table->boolean('is_deleted')->default('0');
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
        Schema::dropIfExists('branches');
    }
}

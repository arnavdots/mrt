<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_code',50)->nullable();
            $table->foreign('product_code')->references('product_code')->on('products');
            $table->string('image',100)->unique();
            $table->boolean('is_active')->default('1');
            $table->softDeletes();
            $table->timestamps();
            $table->index(['product_code', 'image']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galleries');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_code',50)->index();
            $table->string('slug',50)->unique()->index();
            $table->text('invoice_description')->nullable();
            $table->text('specifications')->nullable();
            $table->double('labour_cost', 20, 2)->nullable();
            $table->string('main_image', 255)->nullable();
            $table->integer('weight')->index();
            $table->boolean('is_gst')->default('0')->index();
            $table->double('custom_price', 20, 2)->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->unsignedInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->double('cost_price', 20, 2)->nullable();
            $table->integer('ideal_qty')->nullable()->index();
            $table->integer('alert_level_low_stock')->nullable()->index();
            $table->integer('alert_level_week_sales')->nullable()->index();
            $table->boolean('is_bom')->default('0')->index();
            $table->boolean('is_completed')->default('1')->index();
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->boolean('is_active')->default('1')->index();
            $table->bigInteger('creator_id')->comment('user id');
            $table->bigInteger('modifier_id')->comment('user id');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}

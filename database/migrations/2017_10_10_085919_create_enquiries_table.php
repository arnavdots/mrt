<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contact_name',100);
            $table->string('contact_email',100);
            $table->string('contact_number',25);
            $table->string('contact_address_line_1',100)->nullable();
            $table->string('contact_address_line_2',100)->nullable();
            $table->unsignedInteger('contact_suburb_id')->nullable();
            $table->foreign('contact_suburb_id')->references('id')->on('suburb');
            $table->unsignedInteger('contact_state_id')->nullable();
            $table->foreign('contact_state_id')->references('id')->on('states');
            $table->unsignedInteger('contact_country_id');
            $table->foreign('contact_country_id')->references('id')->on('countries');
            $table->string('contact_postcode',10)->nullable();
            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->unsignedBigInteger('assignee_id')->nullable();
            $table->foreign('assignee_id')->references('id')->on('users');
            $table->unsignedBigInteger('owner_id')->comment('user id');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->string('note',1000)->nullable();
            $table->unsignedInteger('marketing_source_obtained');
            $table->foreign('marketing_source_obtained')->references('id')->on('marketing_sources');
            $table->unsignedInteger('how_enquiry_was_taken');
            $table->foreign('how_enquiry_was_taken')->references('id')->on('enquiry_takens');
            $table->string('ip_address',255)->nullable();
            $table->string('useragent',255)->nullable();
            $table->unsignedSmallInteger('status_id');
            $table->foreign('status_id')->references('id')->on('enquiry_status');
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
        Schema::dropIfExists('enquiries');
    }
}

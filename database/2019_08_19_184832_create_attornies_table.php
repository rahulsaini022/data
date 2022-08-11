<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttorniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attornies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('firm_name');
            $table->string('mname');
            $table->string('document_sign_name');
            $table->string('firm_street_address');
            $table->string('firm_city');
            $table->bigInteger('state_id')->unsigned();
            $table->bigInteger('county_id')->unsigned();
            $table->string('firm_zipcode');
            $table->string('firm_telephone');
            $table->string('special_practice');
            $table->string('special_practice_text');
            $table->bigInteger('attorney_reg_1_state_id')->unsigned();
            $table->bigInteger('attorney_reg_2_state_id')->unsigned();
            $table->bigInteger('attorney_reg_3_state_id')->unsigned();
            $table->string('attorney_reg_1_num');
            $table->string('attorney_reg_2_num');
            $table->string('attorney_reg_3_num');
            $table->timestamps();
        });
        Schema::table('attornies', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('attorney_reg_1_state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('attorney_reg_2_state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('attorney_reg_3_state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attornies');
    }
}

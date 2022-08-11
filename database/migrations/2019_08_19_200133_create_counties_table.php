<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('counties', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->bigInteger('state_id')->unsigned();
        //     $table->string('state_abbreviation');
        //     $table->string('county_name');
        //     $table->string('county_designation');
        //     $table->enum('county_active', ['Y', 'N'])->default('N');
        // });
        Schema::table('counties', function(Blueprint $table) {
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counties');
    }
}

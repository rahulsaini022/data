<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartyattorneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partyattorneys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('case_id')->unsigned()->nullable();
            $table->bigInteger('party_id')->unsigned()->nullable();
            $table->bigInteger('attorney_id')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table('partyattorneys', function(Blueprint $table) {
            $table->foreign('case_id')->references('id')->on('courtcases')->onDelete('cascade');
            $table->foreign('party_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partyattorneys');
    }
}

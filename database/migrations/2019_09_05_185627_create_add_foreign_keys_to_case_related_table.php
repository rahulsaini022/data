<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddForeignKeysToCaseRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  Schema::table('case_users', function(Blueprint $table) {
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
        //     $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        //     $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
        // });

        Schema::table('cases', function(Blueprint $table) {
            // $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
            $table->foreign('court_id')->references('id')->on('courts')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('judge_id')->references('id')->on('judges')->onDelete('cascade');
            $table->foreign('magistrate_id')->references('id')->on('magistrates')->onDelete('cascade');

            $table->foreign('original_state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('original_county_id')->references('id')->on('counties')->onDelete('cascade');
            $table->foreign('original_court_id')->references('id')->on('courts')->onDelete('cascade');
            $table->foreign('original_division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('original_judge_id')->references('id')->on('judges')->onDelete('cascade');
            $table->foreign('original_magistrate_id')->references('id')->on('magistrates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_foreign_keys_to_case_related_table');
    }
}

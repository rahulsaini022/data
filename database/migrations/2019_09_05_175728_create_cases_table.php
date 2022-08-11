<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('attorney_id')->unsigned();
            $table->bigInteger('state_id')->unsigned();
            $table->bigInteger('county_id')->unsigned();
            $table->bigInteger('court_id')->unsigned();
            $table->bigInteger('division_id')->unsigned();
            $table->bigInteger('judge_id')->unsigned();
            $table->bigInteger('magistrate_id')->unsigned();
            $table->string('case_type_ids');
            $table->string('judge_fullname');
            $table->string('magistrate_fullname');
            $table->enum('jury_demand', ['Y', 'N'])->default('N');
            $table->string('sets');
            $table->string('initial_service_types');
            $table->enum('payment_status', ['1', '0'])->default('0');
            $table->enum('is_approved', ['1', '0'])->default('0');
            $table->string('filing_type');
            $table->string('client_role');
            $table->string('opponent_role');
            $table->integer('number_client_role');
            $table->integer('number_opponent_role');
            $table->string('case_number');
            $table->date('date_filed');
            $table->date('date_served');
            $table->date('final_hearing_date');
            $table->string('original_client_role');
            $table->string('original_opponent_role');
            $table->integer('original_number_client_role');
            $table->integer('original_number_opponent_role');
            $table->bigInteger('original_state_id')->unsigned();
            $table->bigInteger('original_county_id')->unsigned();
            $table->bigInteger('original_court_id')->unsigned();
            $table->bigInteger('original_division_id')->unsigned();
            $table->bigInteger('original_judge_id')->unsigned();
            $table->bigInteger('original_magistrate_id')->unsigned();
            $table->string('original_case_number');            
            $table->date('original_date_filed');
            $table->date('original_date_served');
            $table->date('original_final_hearing_date');
            $table->date('original_journalization_date');
            $table->string('original_judge_fullname');
            $table->string('original_magistrate_fullname');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->collation = 'utf8mb4_general_ci';
        });

        // Schema::table('cases', function(Blueprint $table) {
        //     $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
        //     $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        //     $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
        //     $table->foreign('court_id')->references('id')->on('courts')->onDelete('cascade');
        //     $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
        //     $table->foreign('judge_id')->references('id')->on('judges')->onDelete('cascade');
        //     $table->foreign('magistrate_id')->references('id')->on('magistrates')->onDelete('cascade');

        //     $table->foreign('original_state_id')->references('id')->on('states')->onDelete('cascade');
        //     $table->foreign('original_county_id')->references('id')->on('counties')->onDelete('cascade');
        //     $table->foreign('original_court_id')->references('id')->on('courts')->onDelete('cascade');
        //     $table->foreign('original_division_id')->references('id')->on('divisions')->onDelete('cascade');
        //     $table->foreign('original_judge_id')->references('id')->on('judges')->onDelete('cascade');
        //     $table->foreign('original_magistrate_id')->references('id')->on('magistrates')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cases');
    }
}

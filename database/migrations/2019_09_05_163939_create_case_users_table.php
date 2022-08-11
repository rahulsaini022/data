<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('attorney_id')->unsigned();
            $table->bigInteger('case_id')->unsigned();
            $table->string('type');
            $table->string('prefix');
            $table->string('mname');
            $table->string('suffix');
            $table->string('prefname');
            $table->string('telephone');
            $table->enum('gender', ['M', 'F', 'N'])->default('N');
            $table->string('social_sec_number');
            $table->string('date_of_birth');
            $table->string('user_zipcode');
            $table->string('street_address');
            $table->string('user_city');
            $table->bigInteger('state_id')->unsigned();
            $table->bigInteger('county_id')->unsigned();
            $table->string('fax');
            $table->string('primary_language');
            $table->enum('req_lang_trans', ['Y', 'N'])->default('N');
            $table->enum('hearing_impaired', ['Y', 'N'])->default('N');
            $table->enum('req_sign_lang', ['Y', 'N'])->default('N');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->collation = 'utf8mb4_general_ci';
        });

        // Schema::table('case_users', function(Blueprint $table) {
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
        //     $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        //     $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
        // });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_users');
    }
}

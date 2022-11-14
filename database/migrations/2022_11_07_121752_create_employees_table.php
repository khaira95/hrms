<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employeeno');
            $table->string('name');
            $table->string('icno');
            $table->string('email');
            $table->string('address');
            $table->string('contactno');
            $table->string('educationlevel')->nullable();
            $table->string('fieldstudy')->nullable();
            $table->string('designation');
            $table->unsignedBigInteger('workbase_id');
            $table->foreign('workbase_id')->references('id')->on('workbases');
            $table->string('cvno');
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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('workbase_id');
            $table->dropColumn('workbase_id');
        });
    }
}

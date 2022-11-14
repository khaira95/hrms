<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->unsignedBigInteger('workbase_id');
            $table->foreign('workbase_id')->references('id')->on('workbases');
            $table->string('PO_number');
            $table->date('PO_start');
            $table->date('PO_end');
            $table->string('PO_normal_rate');
            $table->string('PO_OT_rate');
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
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropForeign('employee_id');
            $table->dropForeign('workbase_id');
            $table->dropColumn('employee_id');
            $table->dropColumn('workbase_id');
        });
    }
}

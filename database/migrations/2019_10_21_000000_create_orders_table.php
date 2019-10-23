<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashierOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('owner_type');
            $table->unsignedBigInteger('owner_id');
            $table->timestamps();

            $table->string('paypal_id')->nullable(); // id
            $table->string('paypal_parent_id')->nullable(); // parent_id
            $table->string("status"); // status
            $table->string("reference"); // invoice_detail.reference
            $table->string('currency', 3); // invoice_detail.currency_code
            $table->string("note")->nullable(); // invoice_detail.note
            $table->text("terms_and_conditions", 4000)->nullable(); // invoice_detail.terms_and_conditions
            $table->text("memo", 500)->nullable(); // invoice_detail.memo


            $table->integer('total');
            $table->string('paypal_payment_id')->nullable();
            $table->string('paypal_payment_status', 16)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashierAppliedCouponsTable extends Migration
{
    public function up()
    {
        Schema::create("payments", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();

            $table->integer("amount");
            $table->string("currency");
            $table->timestamp("expires_at");
            $table->string("paypal_invoice_id");
            $table->string("paypal_id");
            $table->string("status");
        });
    }

    public function down()
    {
        Schema::dropIfExists("payments");
    }
}

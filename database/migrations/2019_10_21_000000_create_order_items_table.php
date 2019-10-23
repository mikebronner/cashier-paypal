<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashierOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('orderable_type')->nullable();
            $table->unsignedBigInteger('orderable_id')->nullable();
            $table->string('owner_type');
            $table->unsignedBigInteger('owner_id');
            $table->timestamps();

            $table->string("paypal_id")->nullable(); // id
            $table->string('description'); // name
            $table->text('description_extra_lines')->nullable(); //description
            $table->unsignedInteger('quantity')->default(1); // quantity
            $table->integer('unit_price'); // unit_amount.value
            $table->string('currency', 3); // unit_amount.currency_code
            $table->decimal('tax_percentage', 6, 4); // tax
            $table->date("provided_on")->nullable(); // item_date
            $table->integer("discount")->nullable(); // discount.amount.value
            $table->string("discount_type")->nullable(); // discount.<type> 'percent' or 'amount'
            $table->string("unit_of_measure"); // unit_of_measure
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}

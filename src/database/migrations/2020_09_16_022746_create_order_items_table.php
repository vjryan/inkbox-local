<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('order_item_id')->nullable(false)->autoIncrement();
            $table->unsignedBigInteger('order_id')->nullable(false);
            $table->unsignedBigInteger('product_id')->nullable(false);
            $table->integer('quantity')->nullable(false)->default(1);
            $table->unsignedBigInteger('refund')->default(0);
            $table->unsignedBigInteger('resend_amount')->nullable(false)->default(0);
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}

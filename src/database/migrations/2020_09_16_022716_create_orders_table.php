<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable(false)->autoIncrement();
            $table->unsignedBigInteger('order_number')->nullable(false);
            $table->unsignedBigInteger('customer_id')->nullable(false);
            $table->float('total_price', 8, 2)->default(0);
            $table->string('fulfillment_status', 25)->nullable();
            $table->timestamp('fulfilled_date', 0);
            $table->enum('order_status', ['pending','active','done','cancelled','resend'])->nullable(false)->default(null);
            $table->integer('customer_order_count');
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
        Schema::dropIfExists('orders');
    }
}

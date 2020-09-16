<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintSheetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('print_sheet_items', function (Blueprint $table) {
            $table->unsignedBigInteger('psi_id')->length(10)->nullable(false)->autoIncrement();
            $table->unsignedBigInteger('ps_id')->length(10)->nullable(false);
            $table->unsignedBigInteger('order_item_id')->length(20)->nullable(false);
            $table->enum('status', ['pass','reject','complete'])->nullable(false)->default('pass');
            $table->string('image_url', 255)->nullable(false);
            $table->string('size', 255)->nullable(false);
            $table->integer('x_pos')->length(11)->nullable(false);
            $table->integer('y_pos')->length(11)->nullable(false);
            $table->integer('width')->length(11)->nullable(false);
            $table->integer('height')->length(11)->nullable(false);
            $table->string('identifier', 255)->nullable(false);
            $table->timestamps();

            $table->foreign('ps_id')->references('ps_id')->on('print_sheets');
            $table->foreign('order_item_id')->references('order_item_id')->on('order_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('print_sheet_items');
    }
}

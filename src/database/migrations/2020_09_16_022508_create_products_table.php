<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable(false)->autoIncrement();
            $table->string('title', 100)->nullable(false)->default('');
            $table->string('vendor', 50)->nullable();
            $table->string('type', 25)->nullable();
            $table->string('size', 20)->nullable();
            $table->float('price', 8, 2)->default(0);
            $table->string('handle', 50)->nullable();
            $table->integer('inventory_quantity')->default(0);
            $table->string('sku', 30)->nullable();
            $table->string('design_url', 255)->nullable();
            $table->enum('published_state', ['inactive','active'])->nullable(false)->default('active');
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
        Schema::dropIfExists('products');
    }
}

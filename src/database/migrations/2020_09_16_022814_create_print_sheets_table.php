<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('print_sheets', function (Blueprint $table) {
            $table->unsignedBigInteger('ps_id')->nullable(false)->autoIncrement();
            $table->enum('type', ['ecom', 'test'])->nullable(false)->default('ecom');
            $table->string('sheet_url', 255)->nullable(false);
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
        Schema::dropIfExists('print_sheets');
    }
}

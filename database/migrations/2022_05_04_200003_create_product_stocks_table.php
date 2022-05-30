<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->enum('stock_status', ['instock','outofstock'])->default('instock');
            $table->decimal('regular_price', 9,2)->nullable(); // normal Price
            $table->decimal('sales_price', 9,2)->nullable()->default(0); // promo price
            $table->boolean('manage_stock')->default(false);
            $table->bigInteger('stock_quantity')->nullable()->default(0);
            $table->boolean('sold_individually')->default(false);
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
        Schema::dropIfExists('product_stocks');
    }
}

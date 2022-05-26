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
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('sku')->nullable();
            $table->enum('stock_status', ['instock','outofstock'])->default('instock');
            $table->text('features')->nullable();
            $table->decimal('regular_price', 9,2)->nullable(); // normal Price
            $table->decimal('sales_price', 9,2)->default(0); // promo price
            $table->decimal('commission', 9,2)->default(0); // commission
            $table->enum('type', ['digital','physical'])->default('physical');
            $table->enum('product_type', ['simple','variable'])->default('simple');
            $table->boolean('featured')->default(false);
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('product_stock_id')->nullable();
            $table->foreign('product_stock_id')->references('id')->on('product_stocks')->onDelete('cascade');
            $table->bigInteger('views_count')->default(0);
            $table->boolean('manage_stock')->default(false);
            $table->bigInteger('stock_quantity')->nullable()->default(0);
            $table->json('product_attributes')->nullable();
            $table->boolean('sold_individually')->default(false);
            $table->tinyInteger('status')->default(1);
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

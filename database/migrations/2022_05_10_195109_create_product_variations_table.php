<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique()->nullable();
            $table->decimal('price', 8, 2)->nullable()->default(0);
            $table->decimal('cost', 8, 2)->nullable()->default(0);
            $table->integer('quantity')->nullable()->default(0);

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_attribute_id');
            $table->unsignedBigInteger('product_attribute_value_id');
            $table->unsignedBigInteger('product_stock_id')->nullable();

            $table->foreign('product_stock_id')
                ->references('id')
                ->on('product_stocks')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('product_attribute_id')
                ->references('id')
                ->on('product_attributes')
                ->onDelete('cascade');

            $table->foreign('product_attribute_value_id')
                ->references('id')
                ->on('product_attribute_values')
                ->onDelete('cascade');

            $table->unique(['product_id', 'product_attribute_id', 'product_attribute_value_id'], 'product_variation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variations');
    }
}

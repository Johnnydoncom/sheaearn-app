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
            $table->id();
            $table->string('order_number')->unique();
            $table->decimal('grand_total', 9,2);
            $table->unsignedInteger('item_count');
            $table->decimal('shipping_charges')->nullable();
            $table->decimal('taxes')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('delivery_address_id')->nullable();
            $table->text('notes')->nullable();
            $table->tinyInteger('payment_status')->default(\App\Enums\PaymentStatus::PENDING);
            $table->enum('status',
                array_keys(config('appstore.orderstatus'))
            )->default('order_placed');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('delivery_address_id')->references('id')->on('delivery_addresses');
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

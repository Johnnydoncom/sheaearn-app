<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_item_id');
            $table->enum('status',
                [
                    \App\Enums\OrderStatus::PENDING,
                    \App\Enums\OrderStatus::PROCESSING,
                    \App\Enums\OrderStatus::COMPLETED,
                    \App\Enums\OrderStatus::DECLINED,
                    \App\Enums\OrderStatus::CANCELED,
                    \App\Enums\OrderStatus::PLACED,
                    \App\Enums\OrderStatus::IN_PROGRESS,
                    \App\Enums\OrderStatus::SHIPPED,
                    \App\Enums\OrderStatus::OUT_FOR_DELIVERY,
                    \App\Enums\OrderStatus::DELIVERED
                ]
            )->default(\App\Enums\OrderStatus::PLACED);
            $table->text('description')->nullable();
            $table->date('track_date');
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
        Schema::dropIfExists('tracks');
    }
}

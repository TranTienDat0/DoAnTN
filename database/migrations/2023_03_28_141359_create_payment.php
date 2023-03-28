<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id('id');
            $table->tinyInteger('method');
            $table->tinyInteger('status');
            // $table->foreignId('shipping_id')->nullable()
            //     ->constrained('shipping')
            //     ->onDelete('cascade');
            // $table->foreignId('order_id')->nullable()
            //     ->constrained('order')
            //     ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
};

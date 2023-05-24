<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_id')->nullable();
            $table->foreign('created_by_id')
                ->references('id')
                ->on('users');
            $table->enum('status', ['Awaiting Confirmation', 'Order Confirmed', 'Shipped', 'Awaiting Pickup',
                        'Completed', 'Cancelled']);
            $table->text('description')->nullable();
            $table->string('phone')->nullable();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

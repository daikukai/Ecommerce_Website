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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Link to users table, nullable if guest checkout
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_state')->nullable(); // Optional, depending on country
            $table->string('shipping_zip_code');
            $table->string('shipping_country');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); // e.g., pending, processing, completed, cancelled
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

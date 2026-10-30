<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('shipping_method');
            $table->string('payment_method');
            $table->decimal('shipping_price', 8, 2);
            $table->string('town');
            $table->string('street');
            $table->string('house_number');
            $table->string('region');
            $table->string('postal_code');
            $table->string('country');
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
        });
    }
      
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

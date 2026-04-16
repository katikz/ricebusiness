<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rice_id')->constrained('rices')->onDelete('cascade');
            $table->decimal('quantity', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('Pending');
            $table->string('customer_name')->nullable();
            $table->date('delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

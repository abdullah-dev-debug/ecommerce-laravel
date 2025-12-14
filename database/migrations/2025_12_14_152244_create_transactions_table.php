<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('transaction_number')->unique();
            $table->string('method')->nullable();
            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_intent_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->string('status')->nullable();
            $table->json('gateway_response')->nullable();
            $table->timestamps();
            $table->index(['order_id', 'method']);
            $table->index(['status']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

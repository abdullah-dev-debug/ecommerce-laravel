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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('method', ['cod', 'stripe', 'paypal'])->default('cod');
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 10, 2)->default(0);
            $table->boolean('is_cod')->default(false);
            $table->timestamp('cod_collect_at')->nullable();
            $table->string('card_last4')->nullable();
            $table->string('card_brand')->nullable();
            $table->enum('status', ['pending', 'paid', 'failed','refunded'])->default('pending');
            $table->timestamps();
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

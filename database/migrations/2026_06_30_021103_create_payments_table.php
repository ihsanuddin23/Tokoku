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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('midtrans_order_id', 100)->unique();
            $table->string('midtrans_transaction_id', 255)->nullable();
            $table->string('snap_token', 255)->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->string('payment_channel', 100)->nullable();
            $table->decimal('gross_amount', 15, 2);
            $table->string('transaction_status', 50)->default('pending');
            $table->string('fraud_status', 50)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();

            $table->index('midtrans_order_id');
            $table->index('transaction_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

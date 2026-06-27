<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name', 200);
            $table->string('slug', 250)->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->string('sku', 100)->nullable();
            $table->integer('weight')->default(0);
            $table->enum('condition', ['new', 'used'])->default('new');
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->json('images')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->integer('total_sold')->default(0);
            $table->timestamps();

            $table->index(['status', 'category_id']);
            $table->index('seller_profile_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

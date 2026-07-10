<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop both foreign keys first (they both depend on the unique index)
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'product_id']);
        });

        // Add the new column and re-add the foreign keys + new unique index
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->nullable()->after('product_id')->constrained()->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->unique(['user_id', 'product_id', 'product_variant_id'], 'carts_user_product_variant_unique');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
            $table->dropUnique('carts_user_product_variant_unique');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('product_variant_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->unique(['user_id', 'product_id']);
        });
    }
};

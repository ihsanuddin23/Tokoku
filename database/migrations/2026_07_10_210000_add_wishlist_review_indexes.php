<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->index('product_id', 'wishlists_product_id_index');
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->index('user_id', 'reviews_user_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropIndex('wishlists_product_id_index');
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropIndex('reviews_user_id_index');
        });
    }
};

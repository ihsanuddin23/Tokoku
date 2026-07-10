<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index(['status', 'total_sold'], 'products_status_total_sold_index');
            $table->index(['status', 'created_at'], 'products_status_created_at_index');
            $table->index(['status', 'price'], 'products_status_price_index');
            $table->index(['status', 'rating'], 'products_status_rating_index');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index(['user_id', 'status'], 'orders_user_status_index');
            $table->index(['status', 'payment_status'], 'orders_status_payment_index');
            $table->index('payment_status', 'orders_payment_status_index');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index(['product_id', 'status'], 'order_items_product_status_index');
            $table->index(['seller_profile_id', 'status'], 'order_items_seller_status_index');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->index('user_id', 'carts_user_id_index');
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->index(['product_id', 'rating'], 'reviews_product_rating_index');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->index('buyer_id', 'conversations_buyer_id_index');
            $table->index('seller_profile_id', 'conversations_seller_id_index');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->index(['conversation_id', 'created_at'], 'messages_conversation_created_index');
        });

        Schema::table('stock_subscriptions', function (Blueprint $table) {
            $table->index(['product_id', 'notified'], 'stock_subs_product_notified_index');
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->index(['is_active', 'expires_at'], 'vouchers_active_expires_index');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_status_total_sold_index');
            $table->dropIndex('products_status_created_at_index');
            $table->dropIndex('products_status_price_index');
            $table->dropIndex('products_status_rating_index');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_user_status_index');
            $table->dropIndex('orders_status_payment_index');
            $table->dropIndex('orders_payment_status_index');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex('order_items_product_status_index');
            $table->dropIndex('order_items_seller_status_index');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex('carts_user_id_index');
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropIndex('reviews_product_rating_index');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropIndex('conversations_buyer_id_index');
            $table->dropIndex('conversations_seller_id_index');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('messages_conversation_created_index');
        });

        Schema::table('stock_subscriptions', function (Blueprint $table) {
            $table->dropIndex('stock_subs_product_notified_index');
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropIndex('vouchers_active_expires_index');
        });
    }
};

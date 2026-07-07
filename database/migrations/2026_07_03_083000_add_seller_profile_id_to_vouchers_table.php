<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->foreignId('seller_profile_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->index('seller_profile_id');
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropIndex(['seller_profile_id']);
            $table->dropForeign(['seller_profile_id']);
            $table->dropColumn('seller_profile_id');
        });
    }
};

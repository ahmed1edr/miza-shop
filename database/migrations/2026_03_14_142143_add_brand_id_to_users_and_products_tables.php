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
        // كنزيدو العائلة لجدول المستخدمين
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
        });

        // كنزيدو العائلة لجدول السلعة
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};

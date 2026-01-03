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
        Schema::table('product_variants', function (Blueprint $table) {
            // Add color_id and size_id as nullable foreign keys
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete()->after('product_id');
            $table->foreignId('size_id')->nullable()->constrained('sizes')->nullOnDelete()->after('color_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->dropColumn('color_id');

            $table->dropForeign(['size_id']);
            $table->dropColumn('size_id');
        });
    }
};

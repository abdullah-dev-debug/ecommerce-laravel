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
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            // BASIC INFO 
            $table->string('title')->nullable();
            $table->string('sku')->unique();
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();

            //  Foregin key 
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->foreignId('size_id')->nullable()->constrained('sizes')->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();

            // Price
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->decimal('discount_percentage', 5, 2)->nullable();

            // Stock & Inventory 
            $table->integer('low_stock_threshold')->default(10);
            $table->integer('sold_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('quantity')->default(0);

            // Media 
            $table->string('thumbnail')->nullable();

            //   status
            $table->enum('status', ['draft', 'active', 'inactive', 'out_of_stock'])->default('draft');

            // Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('manage_stock')->default(true);

            // Shipping
            $table->decimal('weight', 10, 2)->default(0);
            $table->string('shipping_class')->nullable();

            // Tax
            $table->decimal('vat_tax', 10, 2)->default(0);

            // SEO 
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Dates
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexes 
            $table->index('slug');
            $table->index('sku');
            $table->index(['category_id', 'status']);
            $table->index(['vendor_id', 'status']);
            $table->index('created_at');
            $table->index('price');
            $table->index(['is_featured', 'status', 'created_at']);
            $table->index(['is_bestseller', 'status']);
            $table->index(['quantity', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

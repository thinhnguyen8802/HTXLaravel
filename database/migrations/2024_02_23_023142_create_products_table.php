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
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('cate_id');
            $table->string('name');
            $table->string('slug');
            $table->string('code');
            $table->text('short_desc')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('price_origin');
            $table->unsignedInteger('price_sale');
            $table->string('pcs');
            $table->string('status')->default('1')->comment('1=active');
            $table->integer('quantity_stock')->default(0);
            $table->string('thumbnail')->default('product.png');
            $table->integer('view_count')->default(0);
            $table->integer('count_selling')->default(0);
            $table->timestamps();
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

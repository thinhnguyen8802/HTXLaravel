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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('provinceId');
            $table->integer('districtId');
            $table->integer('wardsId');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->default("");
            $table->string('map')->nullable();
            $table->string('status')->default(0);
            $table->integer('is_banned')->default(1);
            $table->double('rating')->nullable();
            $table->integer('store_views')->default(0);

            // $table->double('latitude')->nullable();
            // $table->double('longitude')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};

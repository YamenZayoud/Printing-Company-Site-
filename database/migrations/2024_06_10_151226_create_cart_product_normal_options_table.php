<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_product_normal_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cart_product_id')->constrained('cart_products')->cascadeOnDelete();
            $table->foreignUuid('normal_option_id')->constrained('normal_attribute_options')->cascadeOnDelete();
            $table->integer('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_product_normal_options');
    }
};

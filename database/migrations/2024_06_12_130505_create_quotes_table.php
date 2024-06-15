<?php

use App\Enums\QuoteStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignUuid('quantity_id')->constrained('product_quantities')->cascadeOnDelete();
            $table->foreignUuid('work_days_id')->constrained('settings')->cascadeOnDelete();
            $table->unsignedInteger('custom_quantity');
            $table->unsignedDouble('quote_price');
            $table->unsignedDouble('expected_price')->nullable();
            $table->string('description')->nullable();
            $table->integer('status')->default(QuoteStatusEnum::Pending);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};

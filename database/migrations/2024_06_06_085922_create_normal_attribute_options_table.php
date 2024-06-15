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
        Schema::create('normal_attribute_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('normal_att_id')->constrained('normal_attributes')->cascadeOnDelete();
            $table->string('name');
            $table->boolean('price_type');
            $table->unsignedDouble('flat_price')->nullable();
            $table->string('formula_price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('normal_attribute_options');
    }
};

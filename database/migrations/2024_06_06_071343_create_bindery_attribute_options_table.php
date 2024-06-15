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
        Schema::create('bindery_attribute_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bindery_att_id')->constrained('bindery_attributes')->cascadeOnDelete();
            $table->string('name');
            $table->unsignedDouble('setup_price');
            $table->unsignedDouble('price_per_unit');
            $table->unsignedDouble('markup');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bindery_attribute_options');
    }
};

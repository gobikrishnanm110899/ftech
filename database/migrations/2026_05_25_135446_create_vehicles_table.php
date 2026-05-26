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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('subcategory_id')->constrained('subcategories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedBigInteger('discount_price')->nullable();
            $table->unsignedSmallInteger('manufacturer_year')->nullable();
            $table->string('fuel_type')->nullable();
            $table->unsignedInteger('km_driven')->nullable();
            $table->string('thumbnail')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('featured')->default(false)->index();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();

            $table->unique(['category_id', 'subcategory_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};

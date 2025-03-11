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
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('SKU')->unique();
            $table->string('featured_image')->nullable();
            $table->string('gallery_image')->nullable();
            $table->string('short_description')->nullable();
            $table->text('description');
            $table->longText('tags')->nullable();
            $table->text('adult_capacity')->nullable();
            $table->text('child_capacity')->nullable();
            $table->boolean('booked')->default(false);
            $table->double('price');
            $table->double('special_price')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();
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

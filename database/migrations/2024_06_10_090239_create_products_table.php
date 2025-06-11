<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('short_description')->nullable(); 
            $table->text('long_description')->nullable(); 
            $table->text('specifications')->nullable(); 
            $table->boolean('is_hot')->default(false);
            $table->integer('is_most_viewed')->default(0);
            $table->string('status')->default('In Stock');
            $table->boolean('has_variants')->default(false);
            $table->decimal('base_price', 10, 2);
            $table->string('image_url');
            $table->json('sub_images_urls')->nullable(); 
            $table->integer('store_quantity')->default(0);
            $table->foreignId('category_id')->constrained('product_categories');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};

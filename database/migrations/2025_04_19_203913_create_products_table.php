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
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            // $table->foreignId('offer_id')->nullable()->constrained('offers')->nullOnDelete();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('images')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 10 ,2);
            $table->boolean('is_active')->default(true); //To Show Product And hide With Out Delete
            $table->boolean('is_featured')->default(false); //To Show Product In Featured Category 
            $table->boolean('in_stock')->default(true);  //To Show user Product IS in Stock Or No
            $table->boolean('on_sale')->default(false);  //To Show user Product have Discount Or Not
            $table->boolean('is_new')->default(false);  //To Show user Product have Discount Or Not
            $table->integer('quantity')->default(0);
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

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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->decimal('discount_price',8,2);
            $table->enum('discount_type',['fixed' , 'percentage'])->nullable();
            $table->json('categories_ids')->nullable(); 
            $table->json('product_ids'); 
    
            $table->date('start_date'); 
            $table->date('end_date');   
    
            $table->boolean('show_on_homepage')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};

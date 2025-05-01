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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('grand_total' ,10 ,2)->nullable(); //The Total Price Contain Products ,Taxes ,Discount, Recharge
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable(); //Only With Payments
            $table->enum('status',['pending' ,'processing' , 'shipped' , 'delivered' ,'canceled'])->default('pending'); //May WithOut Payments
            $table->string('currency')->default('EGP');
            $table->decimal('shipping_amount' ,10,2)->nullable(); //Charge Price
            $table->string('shipping_method')->nullable();   //Charge Method
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

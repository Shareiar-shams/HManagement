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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('room_name');
            $table->string('SKU');
            $table->string('room_price');
            $table->float('total');
            $table->string('floor');
            $table->string('checkinDate');
            $table->string('checkoutDate');
            $table->string('days');
            $table->string('adult_members');
            $table->string('children_members');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->string('tran_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('sex')->nullable();
            $table->string('identification')->nullable();
            $table->string('address')->nullable();
            $table->string('town')->nullable();
            $table->string('postcode')->nullable();
            $table->string('payment_status')->nullable();
            $table->enum('order_status',['Pending','Booked','Checkout','Canceled'])->default('Pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

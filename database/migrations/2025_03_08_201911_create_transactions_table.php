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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('book_id')->nullable();
            $table->string('tran_number')->nullable();
            $table->string('paymentId')->nullable();
            $table->string('gateway_type')->nullable();
            $table->string('amount')->nullable();
            $table->string('transection_time')->nullable();
            $table->string('payment_status')->nullable();
            $table->enum('status',['Default','Paid','Unpaid'])->default('Default');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

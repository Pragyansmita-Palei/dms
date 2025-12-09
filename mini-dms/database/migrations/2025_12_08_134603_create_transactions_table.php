<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('payment_id')->nullable(); // razorpay payment id
            $table->string('order_id_razorpay')->nullable(); // razorpay order id
            $table->string('signature')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('status',['initiated','success','failed'])->default('initiated');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};

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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('f_name');
            $table->string('l_name');
            $table->enum('type', ['billing', 'shipping']);
            $table->string('email');
            $table->string('phone_number');
            $table->string('street_address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('state')->nullable();
            $table->char('country', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};

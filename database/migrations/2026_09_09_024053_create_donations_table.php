<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();        // e.g. TET-DON-92831
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->decimal('amount', 12, 2);            // In LKR
            $table->string('currency')->default('LKR');
            $table->string('payment_method');            // 'card' or 'bank_transfer'
            $table->boolean('is_anonymous')->default(false);
            $table->string('status')->default('pending'); // 'pending', 'verified', 'cancelled'
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('donations');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('enterprise_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();    // e.g. TET-ORD-83921
            $table->string('type');                   // 'product_order' or 'hall_booking'
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('item_name')->nullable();  // Product title or "TET Main Hall"
            $table->integer('quantity')->default(1);
            $table->decimal('estimated_total', 10, 2)->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('new'); // 'new', 'contacted', 'completed', 'cancelled'
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('enterprise_inquiries');
    }
};
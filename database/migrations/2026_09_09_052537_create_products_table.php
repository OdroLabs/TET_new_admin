<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->json('title');                  // Trilingual: { en, si, ta }
            $table->json('description');            // Trilingual description
            $table->decimal('price', 10, 2);        // e.g. 450.00
            $table->string('currency')->default('LKR');
            $table->string('specs')->nullable();    // e.g. "Box of 3 • Packs of 12"
            $table->string('badge')->nullable();    // e.g. "Top Seller"
            $table->string('icon')->default('🛡️');  // Emoji icon
            $table->string('image')->nullable();    // Uploaded photo
            $table->integer('order')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
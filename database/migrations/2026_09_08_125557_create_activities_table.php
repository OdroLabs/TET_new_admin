<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->json('title');          // Trilingual: { en, si, ta }
            $table->json('cat');            // Category: Field Aid, Healthcare, etc.
            $table->string('date');         // Date text e.g. "Today • Aug 24, 2026"
            $table->json('location');       // Location text
            $table->json('excerpt');        // Short card summary
            $table->json('full_story');     // Detailed modal story
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('activities');
    }
};
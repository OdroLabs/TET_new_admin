<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('cat');
            $table->string('date');
            $table->json('location');
            $table->json('excerpt');
            $table->json('full_story');
            $table->string('cover_image')->nullable();
            $table->json('gallery_images')->nullable(); // Array of sub-images
            $table->integer('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('events');
    }
};
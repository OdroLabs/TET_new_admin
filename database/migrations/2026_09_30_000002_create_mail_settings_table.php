<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_enabled')->default(false);
            $table->string('host')->nullable();
            $table->unsignedInteger('port')->default(587);
            $table->string('encryption')->default('tls');      // tls | ssl | none
            $table->string('username')->nullable();
            $table->text('password')->nullable();               // stored encrypted
            $table->string('from_address')->nullable();
            $table->string('from_name')->nullable();
            $table->json('to_addresses')->nullable();           // ["a@x.lk", ...]
            $table->json('cc_addresses')->nullable();           // ["b@x.lk", ...]
            $table->boolean('notify_contact')->default(true);
            $table->boolean('notify_inquiries')->default(true);
            $table->boolean('notify_donations')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_settings');
    }
};

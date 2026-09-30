<?php

use Illuminate\Database\Migrations\Migration;

/** Wording for the "Preview mode" bar shown to admins while Coming Soon is on. */
return new class extends Migration {
    public function up(): void
    {
        (new \Database\Seeders\SiteContentSeeder())->run();   // only fills missing keys
    }

    public function down(): void
    {
    }
};

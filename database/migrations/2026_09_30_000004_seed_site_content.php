<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The website no longer carries any hardcoded text or default lists; everything
 * comes from the database. This fills in the content the site used to fall back
 * to, without touching anything already edited in the admin.
 */
return new class extends Migration {
    public function up(): void
    {
        (new \Database\Seeders\SiteContentSeeder())->run();

        // Lists the website used to fall back to when these tables were empty
        if (DB::table('events')->count() === 0) (new \Database\Seeders\EventSeeder())->run();
        if (DB::table('activities')->count() === 0) (new \Database\Seeders\ActivitySeeder())->run();
        if (DB::table('products')->count() === 0) (new \Database\Seeders\ProductSeeder())->run();
    }

    public function down(): void
    {
        // Content stays: it may have been edited since.
    }
};

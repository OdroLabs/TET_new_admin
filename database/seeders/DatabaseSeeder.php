<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Default TET Administrator
        User::updateOrCreate(
            ['email' => 'admin@tet.lk'],
            [
                'name' => 'TET Administrator',
                'password' => Hash::make('SecretPassword123!'), // 👈 Change this to your secure password
            ]
        );

        $this->call([
            ActivitySeeder::class,
            EventSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
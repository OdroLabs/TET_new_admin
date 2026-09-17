<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'title' => [
                    'en' => 'Ultra-Thin Sensitive Latex Condoms',
                    'si' => 'අතිශය තුනී ආරක්ෂිත ලේටෙක්ස් කොන්ඩම්',
                    'ta' => 'அல்ட்ரா தின் லேடெக்ஸ் காண்டம்கள்'
                ],
                'description' => [
                    'en' => 'Internationally ISO 4074 certified latex condoms designed for maximum sensitivity, durability, and reliable protection.',
                    'si' => 'උපරිම සංවේදීතාව සහ කල්පැවැත්ම සහිත ISO 4074 සහතිකලත් කොන්ඩම්.',
                    'ta' => 'அதிகபட்ச உணர்திறன் மற்றும் பாதுகாப்பிற்கான சர்வதேச தர சான்றிதழ் பெற்ற காண்டம்கள்.'
                ],
                'price' => 450.00,
                'currency' => 'LKR',
                'specs' => 'Box of 3 • Packs of 12',
                'badge' => 'Top Seller',
                'icon' => '🛡️',
                'order' => 1,
                'is_available' => true,
            ],
            [
                'title' => [
                    'en' => 'Extra-Lubricated Barrier Protection',
                    'si' => 'අමතර ලිහිසි සහිත ආරක්ෂිත කොන්ඩම්',
                    'ta' => 'கூடுதல் லூப்ரிகேட்டட் பாதுகாப்பு காண்டம்கள்'
                ],
                'description' => [
                    'en' => 'Pre-lubricated with non-sticky, skin-safe formula providing frictionless comfort and tear-resistance.',
                    'si' => 'ඇලෙන සුළු නොවන, සමට හිතකර ආරක්ෂිත ලිහිසි ද්‍රව්‍ය සහිතයි.',
                    'ta' => 'சருமத்திற்கு பாதுகாப்பான உராய்வற்ற வசதியை வழங்கும் வடிவம்.'
                ],
                'price' => 550.00,
                'currency' => 'LKR',
                'specs' => 'Packs of 12 • Bulk 50s',
                'badge' => 'High Durability',
                'icon' => '💧',
                'order' => 2,
                'is_available' => true,
            ],
            [
                'title' => [
                    'en' => 'Community Safe-Sex Wellness Kits',
                    'si' => 'ප්‍රජා ආරක්ෂිත ලිංගික සුවතා කට්ටලය',
                    'ta' => 'சமூக பாதுகாப்பான பாலியல் சுகாதார தொகுப்பு'
                ],
                'description' => [
                    'en' => 'Includes 6 condoms, 3 water-based lubricant sachets, and trilingual sexual health education guides.',
                    'si' => 'කොන්ඩම් 6ක්, ලිහිසි ද්‍රව්‍ය පැකට් 3ක් සහ ත්‍රෛභාෂා සෞඛ්‍ය මාර්ගෝපදේශ ඇතුළත් වේ.',
                    'ta' => '6 காண்டம்கள், 3 லூப்ரிகண்ட் பாக்கெட்டுகள் மற்றும் முமொழி வழிகாட்டி அடங்கியது.'
                ],
                'price' => 750.00,
                'currency' => 'LKR',
                'specs' => 'Full Wellness Kit',
                'badge' => 'Inclusive Kit',
                'icon' => '🎁',
                'order' => 3,
                'is_available' => true,
            ],
        ];

        foreach ($products as $item) {
            Product::create($item);
        }
    }
}
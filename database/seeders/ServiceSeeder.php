<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /** The six services the website shipped with. */
    public static function defaults(): array
    {
        $desc = 'Our specialized team provides immediate intervention and support ensuring fundamental rights are upheld.';

        return [
            ['tag' => 'Legal', 'title' => 'Legal Aid & Human Rights', 'description' => $desc, 'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f'],
            ['tag' => 'Healthcare', 'title' => 'Medical Healthcare Access', 'description' => $desc, 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d'],
            ['tag' => 'Wellness', 'title' => 'Mental Health & Counseling', 'description' => $desc, 'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2'],
            ['tag' => 'Advocacy', 'title' => 'Community Support & Safety', 'description' => $desc, 'image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac'],
            ['tag' => 'Growth', 'title' => 'Employment & Skills Training', 'description' => $desc, 'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978'],
            ['tag' => 'Emergency', 'title' => 'Crisis Intervention', 'description' => $desc, 'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216'],
        ];
    }

    public function run(): void
    {
        if (Service::exists()) {
            return;
        }

        foreach (static::defaults() as $i => $d) {
            $service = new Service();
            foreach (['tag', 'title', 'description'] as $field) {
                $service->setTranslations($field, ['en' => $d[$field], 'si' => '', 'ta' => '']);
            }
            $service->image = $d['image'];
            $service->order = $i + 1;
            $service->is_published = true;
            $service->save();
        }
    }
}

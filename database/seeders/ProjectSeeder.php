<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        if (Project::exists()) {
            return;
        }

        $tri = fn (string $en) => ['en' => $en, 'si' => '', 'ta' => ''];

        $projects = [
            [
                'category' => 'Legal & Policy Advocacy',
                'title1' => 'Sex Work Policy', 'title2' => 'Consortium',
                'summary' => 'A multi-stakeholder advocacy alliance drafting constitutional reform papers and legal safeguards to eliminate arbitrary police detention and systemic discrimination.',
                'long_desc' => 'The Sex Work Policy Consortium unites human rights lawyers, trans community organizers, and constitutional experts. We provide direct paralegal intervention for arbitrarily detained trans individuals, document human rights infractions, and engage with parliamentary caucuses to reform colonial-era vagrancy statutes. Our field research informs official policy whitepapers submitted to the Ministry of Justice.',
                'status' => 'Active / Phase 02',
                'images' => [
                    'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4',
                    'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2',
                    'https://images.unsplash.com/photo-1450133064473-71024230f91b',
                ],
            ],
            [
                'category' => 'Economic Empowerment',
                'title1' => 'Digital Literacy &', 'title2' => 'Employment Paths',
                'summary' => 'Vocational training bootcamps providing IT skills, resume building, and dignified corporate placement partnerships for transgender youth in Colombo and Kandy.',
                'long_desc' => 'Economic independence is the single most effective defense against exploitation. Our bootcamps train transgender youth in full-stack web basics, graphic design, social media management, and workplace English. Concurrently, TET sensitizes corporate HR leaders and tech firms in Sri Lanka, opening affirmative hiring pipelines with equal benefits and zero harassment guarantees.',
                'status' => '150+ Graduates',
                'images' => [
                    'https://images.unsplash.com/photo-1522202176988-66273c2fd55f',
                    'https://images.unsplash.com/photo-1531482615713-2afd69097998',
                    'https://images.unsplash.com/photo-1522071820081-009f0129c71c',
                ],
            ],
            [
                'category' => 'Emergency Relief & Shelter',
                'title1' => 'TET Safe Spaces &', 'title2' => 'Crisis Aid',
                'summary' => 'Providing short-term transitional housing, food relief kits, and crisis mental health counseling for displaced and vulnerable transgender individuals nationwide.',
                'long_desc' => "Many transgender youth in Sri Lanka face sudden eviction and family abandonment upon coming out. TET's Safe Spaces project operates confidential, secure emergency houses in key districts. Residents receive safe shelter, daily nutrition, trauma-informed psychological triage, and assistance in obtaining emergency identification cards to regain independence.",
                'status' => '24/7 Available',
                'images' => [
                    'https://images.unsplash.com/photo-1529156069898-49953e39b3ac',
                    'https://images.unsplash.com/photo-1573164713988-8665fc963095',
                    'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca',
                ],
            ],
            [
                'category' => 'Health & Well-being',
                'title1' => 'Affirmative Healthcare', 'title2' => 'Access Network',
                'summary' => 'Bridging community members with sensitized medical practitioners, hormone therapy guidance, and confidential psychiatric counseling free of judgment.',
                'long_desc' => 'Discrimination in clinical environments often deters trans individuals from seeking critical medical care. Through this network, TET trains doctors, endocrinologists, and counselors in World Professional Association for Transgender Health (WPATH) standards, connecting community members to safe medical transition pathways, STI testing, and mental wellness care.',
                'status' => 'Islandwide Support',
                'images' => [
                    'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d',
                    'https://images.unsplash.com/photo-1505751172876-fa1923c5c528',
                    'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982',
                ],
            ],
        ];

        foreach ($projects as $i => $data) {
            $project = new Project();
            foreach (['category', 'title1', 'title2', 'summary', 'long_desc', 'status'] as $field) {
                $project->setTranslations($field, $tri($data[$field]));
            }
            $project->images = $data['images'];
            $project->order = $i + 1;
            $project->is_published = true;
            $project->save();
        }
    }
}

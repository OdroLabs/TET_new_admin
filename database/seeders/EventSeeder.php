<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => ['en' => 'Voices of Hope: National Transgender Symposium', 'si' => 'බලාපොරොත්තුවේ හඬ: ජාතික සංක්‍රාන්ති ලිංගික සමුළුව', 'ta' => 'நம்பிக்கையின் குரல்கள்: தேசிய மாநாடு'],
                'cat' => ['en' => 'Community Dialogue', 'si' => 'ප්‍රජා සංවාදය', 'ta' => 'சமூக கலந்துரையாடல்'],
                'date' => 'OCT 14, 2026',
                'location' => ['en' => 'Colombo, Sri Lanka', 'si' => 'කොළඹ, ශ්‍රී ලංකාව', 'ta' => 'கொழும்பு, இலங்கை'],
                'excerpt' => ['en' => 'Over 120 grassroots organizers gathered in Colombo to discuss affirmative healthcare access and constitutional protection.', 'si' => 'සෞඛ්‍ය හා ව්‍යවස්ථාපිත අයිතිවාසිකම් පිළිබඳ සාකච්ඡා කිරීමට සංවිධායකයින් 120කට වැඩි පිරිසක් එක්විය.', 'ta' => '120க்கும் மேற்பட்டோர் பங்கேற்ற கலந்துரையாடல்.'],
                'full_story' => ['en' => 'The National Transgender Symposium united transgender activists, medical professionals, and human rights lawyers from across Sri Lanka. Key discussion tracks included safe shelter networks, addressing workplace harassment, and drafting legal reform recommendations to eliminate discriminatory laws.', 'si' => 'ශ්‍රී ලංකාව පුරා ක්‍රියාකාරීන් සහ නීතිඥයින්ගේ සහභාගීත්වයෙන් පැවැත්විණි.', 'ta' => 'நாடு முழுவதிலுமிருந்து ஆர்வலர்கள் மற்றும் வழக்கறிஞர்கள் பங்கேற்றனர்.'],
                'cover_image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4',
                    'https://images.unsplash.com/photo-1529156069898-49953e39b3ac'
                ],
                'order' => 1,
            ],
            [
                'title' => ['en' => 'Peer Circles: Creative Expression & Mental Health', 'si' => 'මිතුරු හමුව: නිර්මාණාත්මක ප්‍රකාශනය සහ මානසික සුවය', 'ta' => 'கலை வெளிப்பாடு மற்றும் மனநலம்'],
                'cat' => ['en' => 'Youth & Empowerment', 'si' => 'තරුණ සවිබල ගැන්වීම', 'ta' => 'இளைஞர் வலுவூட்டல்'],
                'date' => 'SEP 28, 2026',
                'location' => ['en' => 'Kandy Safe House', 'si' => 'මහනුවර ආරක්ෂිත නවාතැන', 'ta' => 'கண்டி மையம்'],
                'excerpt' => ['en' => 'A safe weekend retreat focusing on art therapy, trauma healing, and peer mentorship for trans youth.', 'si' => 'කලා චිකිත්සාව සහ මානසික සුවය පිළිබඳ තරුණ වැඩසටහනක්.', 'ta' => 'இளைஞர்களுக்கான மனநல கலைப் பட்டறை.'],
                'full_story' => ['en' => 'Led by certified counseling liaisons, this workshop provided a non-judgmental sanctuary for gender-diverse youth. Participants engaged in art therapy, storytelling circles, and psycho-social coping strategies, culminating in a collective community mural.', 'si' => 'සහතිකලත් උපදේශකයින් විසින් මෙහෙයවන ලද සාර්ථක වැඩසටහනකි.', 'ta' => 'சான்றளிக்கப்பட்ட ஆலோசகர்களால் வழிநடத்தப்பட்ட நிகழ்வு.'],
                'cover_image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1511632765486-a01980e01a18',
                    'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8'
                ],
                'order' => 2,
            ],
            [
                'title' => ['en' => 'Legal Rights & Anti-Discrimination Training', 'si' => 'නීතිමය අයිතිවාසිකම් සහ වෙනස්කොට සැලකීමට එරෙහි පුහුණුව', 'ta' => 'சட்ட உரிமைகள் மற்றும் பாகுபாடு எதிர்ப்பு பயிற்சி'],
                'cat' => ['en' => 'Advocacy & Law', 'si' => 'නීතිය සහ උපදේශනය', 'ta' => 'சட்டம் மற்றும் வாதாடல்'],
                'date' => 'AUG 19, 2026',
                'location' => ['en' => 'Galle Heritage Hall', 'si' => 'ගාල්ල උරුම ශාලාව', 'ta' => 'காலி மண்டபம்'],
                'excerpt' => ['en' => 'Training community paralegals to navigate police arbitrary detentions and legal gender recognition paperwork.', 'si' => 'අත්තනෝමතික අත්අඩංගුවට ගැනීම් සහ නීතිමය ලියකියවිලි පිළිබඳ පුහුණුවක්.', 'ta' => 'கைதுகள் மற்றும் ஆவணங்கள் தொடர்பான சட்டப் பயிற்சி.'],
                'full_story' => ['en' => 'This legal education summit equipped community members with critical knowledge regarding fundamental rights under the Constitution of Sri Lanka, safe reporting protocols, and legal identity card (NIC) gender change procedures.', 'si' => 'මූලික අයිතිවාසිකම් පිළිබඳ වැදගත් තොරතුරු ලබා දුන්නේය.', 'ta' => 'அடிப்படை உரிமைகள் குறித்த தகவல்கள் வழங்கப்பட்டன.'],
                'cover_image' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1450133064473-71024230f91b',
                    'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2'
                ],
                'order' => 3,
            ],
            [
                'title' => ['en' => 'Digital Skills & Freelance Career Bootcamp', 'si' => 'ඩිජිටල් කුසලතා සහ මාර්ගගත රැකියා පුහුණුව', 'ta' => 'டிஜிட்டல் திறன் மற்றும் தொழில் பயிற்சி'],
                'cat' => ['en' => 'Social Enterprise', 'si' => 'සමාජ ව්‍යවසාය', 'ta' => 'சமூக நிறுவனம்'],
                'date' => 'JUL 30, 2026',
                'location' => ['en' => 'TET Innovation Hub', 'si' => 'TET නවෝත්පාදන කේන්ද්‍රය', 'ta' => 'TET புத்தாக்க மையம்'],
                'excerpt' => ['en' => 'A 4-week vocational technology workshop providing IT skills, graphic design, and freelance career paths.', 'si' => 'තොරතුරු තාක්ෂණය සහ ග්‍රැෆික් නිර්මාණකරණය පිළිබඳ සති 4ක පාඨමාලාවක්.', 'ta' => '4 வார கணினி மற்றும் வடிவமைப்பு பயிற்சி.'],
                'full_story' => ['en' => 'To foster financial independence, TET partnered with ethical tech firms to offer hands-on training in digital design, coding fundamentals, and remote client management, enabling graduates to secure dignified online employment.', 'si' => 'ආර්ථික නිදහස උදෙසා තාක්ෂණික සමාගම් සමඟ එක්ව පැවැත්වූ වැඩමුළුවකි.', 'ta' => 'ஆன்லைன் வேலைவாய்ப்புகளைப் பெற நடத்தப்பட்ட பயிற்சி.'],
                'cover_image' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1522202176988-66273c2fd55f',
                    'https://images.unsplash.com/photo-1531482615713-2afd69097998'
                ],
                'order' => 4,
            ],
            [
                'title' => ['en' => 'Pride Solidarity Walk & Community Day', 'si' => 'ප්‍රයිඩ් සහයෝගිතා පාගමන සහ ප්‍රජා දිනය', 'ta' => 'பெருமை நடைபயணம் மற்றும் சமூக தினம்'],
                'cat' => ['en' => 'Solidarity Gathering', 'si' => 'සහයෝගිතා හමුව', 'ta' => 'ஒற்றுமை கூட்டம்'],
                'date' => 'JUN 18, 2026',
                'location' => ['en' => 'Negombo Coastline', 'si' => 'මීගමුව වෙරළ තීරය', 'ta' => 'நீர்கொழும்பு கடற்கரை'],
                'excerpt' => ['en' => 'Celebrating transgender pride, identity visibility, and mutual aid along the western coast.', 'si' => 'සංක්‍රාන්ති ලිංගික අනන්‍යතාවය සැමරීමේ සහයෝගිතා පාගමනක්.', 'ta' => 'அடையாளத்தை கொண்டாடும் நடைபயணம்.'],
                'full_story' => ['en' => 'Over 200 community members and allies gathered for a joyful day of music, shared meals, and solidarity speeches celebrating the resilience, beauty, and ongoing struggle of Sri Lanka\'s transgender community.', 'si' => '200කට අධික පිරිසකගේ සහභාගීත්වයෙන් උත්සවාකාරයෙන් පැවැත්විණි.', 'ta' => '200க்கும் மேற்பட்டோர் ஒன்று கூடி கொண்டாடினர்.'],
                'cover_image' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1523240795612-9a054b0db644',
                    'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d'
                ],
                'order' => 5,
            ],
            [
                'title' => ['en' => 'Hormone Therapy & Safe Healthcare Forum', 'si' => 'හෝමෝන ප්‍රතිකාර සහ ආරක්ෂිත සෞඛ්‍ය සංසදය', 'ta' => 'ஹார்மோன் சிகிச்சை மற்றும் சுகாதார மன்றம்'],
                'cat' => ['en' => 'Healthcare Workshop', 'si' => 'සෞඛ්‍ය වැඩමුළුව', 'ta' => 'சுகாதார பட்டறை'],
                'date' => 'MAY 12, 2026',
                'location' => ['en' => 'Jaffna Community Clinic', 'si' => 'යාපනය ප්‍රජා සායනය', 'ta' => 'யாழ்ப்பாணம் சமூக மருத்துவமனை'],
                'excerpt' => ['en' => 'Sensitizing medical professionals and providing free health consultations for transgender individuals.', 'si' => 'වෛද්‍යවරුන් සංවේදී කිරීම සහ නොමිලේ සෞඛ්‍ය උපදෙස් ලබා දීම.', 'ta' => 'இலவச மருத்துவ ஆலோசனைகள் வழங்கப்பட்டன.'],
                'full_story' => ['en' => 'In collaboration with sensitized physicians, TET hosted a consultation clinic providing blood checkups, affirmative hormone therapy counseling, and psychological wellness assessments in an environment free of stigma.', 'si' => 'වෛද්‍යවරුන්ගේ සහභාගීත්වයෙන් නොමිලේ උපදේශන සායනයක් පැවැත්විණි.', 'ta' => 'மருத்துவர்களின் உதவியுடன் ஆலோசனை முகாம் நடைபெற்றது.'],
                'cover_image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d',
                    'https://images.unsplash.com/photo-1505751172876-fa1923c5c528'
                ],
                'order' => 6,
            ],
        ];

        foreach ($events as $item) {
            Event::create($item);
        }
    }
}
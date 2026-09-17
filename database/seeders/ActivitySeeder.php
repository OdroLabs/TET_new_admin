<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'title' => ['en' => 'Healthcare Sensitization & Hospital Outreach', 'si' => 'සෞඛ්‍ය සේවා සංවේදීකරණය සහ රෝහල් ප්‍රවේශය', 'ta' => 'சுகாதார விழிப்புணர்வு மற்றும் மருத்துவமனை தொடர்பு'],
                'cat' => ['en' => 'Healthcare', 'si' => 'සෞඛ්‍යය', 'ta' => 'சுகாதாரம்'],
                'date' => 'Today • Aug 24, 2026',
                'location' => ['en' => 'Colombo General Hospital Area', 'si' => 'කොළඹ මහ රෝහල ප්‍රදේශය', 'ta' => 'கொழும்பு பொது வைத்தியசாலை பகுதி'],
                'excerpt' => ['en' => 'Conducted medical orientation sessions for outpatient staff to eliminate stigma against transgender patients.', 'si' => 'බාහිර රෝගී කාර්ය මණ්ඩලය සඳහා සංවේදීකරණ සැසි පැවැත්වීම.', 'ta' => 'வெளிநோயாளர் ஊழியர்களுக்கான விழிப்புணர்வு அமர்வுகள்.'],
                'full_story' => ['en' => 'Our field team visited outpatient facilities to provide staff with respectful interaction guidelines, hormone care referrals, and legal identity verification protocols, ensuring transgender patients receive affirmative and dignified care.', 'si' => 'අපගේ කණ්ඩායම බාහිර රෝගී අංශ වෙත ගොස් මාර්ගෝපදේශ ලබා දුන්නේය.', 'ta' => 'எங்கள் குழு வெளிநோயாளர் பிரிவுகளுக்கு சென்று வழிகாட்டுதல்களை வழங்கியது.'],
                'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514',
                'order' => 1,
            ],
            [
                'title' => ['en' => 'Economic Resilience & Small Business Grants', 'si' => 'ආර්ථික ප්‍රතිරෝධය සහ කුඩා ව්‍යාපාර ප්‍රදාන', 'ta' => 'பொருளாதார மேம்பாடு மற்றும் சிறு வணிக மானியங்கள்'],
                'cat' => ['en' => 'Empowerment', 'si' => 'සවිබල ගැන්වීම', 'ta' => 'அதிகாரமளித்தல்'],
                'date' => 'Aug 20, 2026',
                'location' => ['en' => 'Kandy District Centre', 'si' => 'මහනුවර දිස්ත්‍රික් මධ්‍යස්ථානය', 'ta' => 'கண்டி மாவட்ட மையம்'],
                'excerpt' => ['en' => 'Disbursed micro-grants and financial literacy tools to 12 trans-led micro enterprises and freelancers.', 'si' => 'ව්‍යවසායකයින් 12 දෙනෙකුට ක්ෂුද්‍ර ප්‍රදාන ලබා දීම.', 'ta' => '12 தொழில்முனைவோருக்கு நுண் மானியங்கள் வழங்குதல்.'],
                'full_story' => ['en' => 'Through our economic recovery fund, 12 beneficiaries received seed micro-grants for baking, tailoring, and freelance tech equipment, accompanied by one-on-one bookkeeping coaching.', 'si' => 'අපගේ අරමුදල හරහා ව්‍යවසායකයින් 12 දෙනෙකුට ආධාර ලැබුණි.', 'ta' => 'எங்கள் நிதியுதவி மூலம் 12 பேர் பயனடைந்தனர்.'],
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f',
                'order' => 2,
            ],
            [
                'title' => ['en' => 'Emergency Crisis Intervention & Shelter Distribution', 'si' => 'හදිසි ආපදා මැදිහත්වීම සහ නවාතැන් බෙදාහැරීම', 'ta' => 'அவசர கால தலையீடு மற்றும் புகலிட வசதி'],
                'cat' => ['en' => 'Field Aid', 'si' => 'ක්ෂේත්‍ර ආධාර', 'ta' => 'கள உதவி'],
                'date' => 'Aug 15, 2026',
                'location' => ['en' => 'Galle Safe Space Hub', 'si' => 'ගාල්ල ආරක්ෂිත නවාතැන', 'ta' => 'காலி பாதுகாப்பு மையம்'],
                'excerpt' => ['en' => 'Assisted three displaced trans youth with urgent housing aid, nutrition rations, and psycho-social checkups.', 'si' => 'අවතැන් වූ තරුණයින් තිදෙනෙකුට හදිසි නවාතැන් ආධාර ලබා දීම.', 'ta' => 'பாதிக்கப்பட்ட மூன்று இளைஞர்களுக்கு அவசர உதவி வழங்கப்பட்டது.'],
                'full_story' => ['en' => 'Responding to emergency hotline calls, our rapid response coordinators safely transferred three at-risk community members into temporary shelter and connected them with affirmative counselors.', 'si' => 'හදිසි ඇමතුම් වලට ප්‍රතිචාර දක්වමින් ආරක්ෂිත නවාතැන් ලබා දෙන ලදී.', 'ta' => 'அவசர அழைப்புகளுக்கு பதிலளித்து தற்காலிக புகலிடம் வழங்கப்பட்டது.'],
                'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4',
                'order' => 3,
            ],
            [
                'title' => ['en' => 'Legal Identity Paperwork & NIC Clinic', 'si' => 'නීතිමය අනන්‍යතා ලියකියවිලි සහ ජා.හැ. සායනය', 'ta' => 'தேசிய அடையாள அட்டை திருத்த முகாம்'],
                'cat' => ['en' => 'Advocacy', 'si' => 'නීතිමය මැදිහත්වීම', 'ta' => 'சட்ட ஆதரவு'],
                'date' => 'Aug 10, 2026',
                'location' => ['en' => 'Negombo Community Hall', 'si' => 'මීගමුව ප්‍රජා ශාලාව', 'ta' => 'நீர்கொழும்பு சமூக மண்டபம்'],
                'excerpt' => ['en' => 'Assisted 24 community members in submitting official legal gender and name change applications.', 'si' => 'ප්‍රජා සාමාජිකයින් 24 දෙනෙකුට ලිපිලේඛන සකස් කිරීමට සහාය වීම.', 'ta' => '24 சமூக உறுப்பினர்களுக்கு ஆவணங்கள் சமர்ப்பிக்க உதவப்பட்டது.'],
                'full_story' => ['en' => 'Our legal aid officers reviewed birth certificates, medical certificates, and DS paperwork to streamline name and gender marker corrections on National Identity Cards without arbitrary harassment.', 'si' => 'ජාතික හැඳුනුම්පත් සංශෝධනය සඳහා නීතිමය නිලධාරීන් සහාය විය.', 'ta' => 'தேசிய அடையாள அட்டை திருத்தங்களுக்கு சட்ட அதிகாரிகள் உதவினர்.'],
                'image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b',
                'order' => 4,
            ],
            [
                'title' => ['en' => 'Safe Youth Peer Circle & Healing Workshop', 'si' => 'ආරක්ෂිත තරුණ හමුව සහ සුවපත් කිරීමේ වැඩමුළුව', 'ta' => 'இளைஞர் கலந்துரையாடல் மற்றும் மனநல பட்டறை'],
                'cat' => ['en' => 'Safe Spaces', 'si' => 'ආරක්ෂිත පරිසරය', 'ta' => 'பாதுகாப்பான இடம்'],
                'date' => 'Aug 05, 2026',
                'location' => ['en' => 'TET Colombo Studio', 'si' => 'TET කොළඹ මැදිරිය', 'ta' => 'TET கொழும்பு மையம்'],
                'excerpt' => ['en' => 'Held a closed peer-mentorship circle focusing on resilience, self-acceptance, and mental wellness.', 'si' => 'මානසික සුවතාවය සහ පිළිගැනීම පිළිබඳ උපදේශන සැසියක් පැවැත්වීම.', 'ta' => 'மனநலம் மற்றும் சுய முன்னேற்றம் குறித்த விழிப்புணர்வு.'],
                'full_story' => ['en' => 'Led by trans peer leaders, 30 young participants shared personal journeys, participated in grounding exercises, and built support bonds in a 100% confidential and loving environment.', 'si' => 'තරුණයින් 30 දෙනෙකුගේ සහභාගීත්වයෙන් සාර්ථකව පවත්වන ලදී.', 'ta' => '30 இளைஞர்கள் பங்கேற்ற ஒரு வெற்றிகரமான நிகழ்வு.'],
                'image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac',
                'order' => 5,
            ],
            [
                'title' => ['en' => 'Nutritional Rations & Community Care Drive', 'si' => 'පෝෂණ සලාක සහ ප්‍රජා සත්කාර වැඩසටහන', 'ta' => 'உணவு மற்றும் அத்தியாவசியப் பொருட்கள் வழங்கல்'],
                'cat' => ['en' => 'Field Aid', 'si' => 'ක්ෂේත්‍ර ආධාර', 'ta' => 'கள உதவி'],
                'date' => 'July 28, 2026',
                'location' => ['en' => 'Ratnapura Outskirts', 'si' => 'රත්නපුර අවට ප්‍රදේශ', 'ta' => 'இரத்தினபுரி பகுதி'],
                'excerpt' => ['en' => 'Distributed monthly food rations and hygiene care packs to elderly and vulnerable community elders.', 'si' => 'වැඩිහිටි ප්‍රජා සාමාජිකයින්ට වියළි සලාක බෙදා දීම.', 'ta' => 'முதியவர்களுக்கு உலர் உணவுப் பொதிகள் வழங்கப்பட்டன.'],
                'full_story' => ['en' => 'TET volunteers packed and transported dry food rations, sanitary packages, and basic medicine to elder transgender members who face social isolation and reduced employment opportunities.', 'si' => 'ස්වේච්ඡා සාමාජිකයින් විසින් වියළි සලාක සහ සනීපාරක්ෂක ද්‍රව්‍ය බෙදා දෙන ලදී.', 'ta' => 'தன்னார்வலர்கள் மூலம் உலர் உணவுப் பொதிகள் வழங்கப்பட்டன.'],
                'image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433',
                'order' => 6,
            ],
        ];

        foreach ($activities as $item) {
            Activity::create($item);
        }
    }
}
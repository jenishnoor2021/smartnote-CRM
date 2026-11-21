<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Slider;
use Illuminate\Support\Str;

class FrontWebsiteSeeder extends Seeder
{
    public function run()
    {
        // 1. Site Settings
        $settings = [
            'site_name' => 'SMART NOTES PUBLICATION PVT. LTD.',
            'site_tagline' => 'School Books Publisher | Nursery to Class 8',
            'phone_primary' => '+91 99798-65666',
            'phone_secondary' => '+91 92130-05642',
            'whatsapp_number' => '919979865666',
            'email_primary' => 'smartnotespublication@gmail.com',
            'email_secondary' => 'Sevenhigheducationpvtltd@gmail.com',
            'office_surat_address' => '222 to 224, Prime Shoppers, Opp. Safal Square, Udhna-magdalla Road, Vesu, Surat - 395007',
            'office_mumbai_address' => '33, Pragati Icon, A. S. Gawade Marg, Pant Nagar, Mumbai, Maharashtra-400075',
            'facebook_url' => 'https://www.facebook.com/SmartNotesPublication',
            'instagram_url' => 'https://www.instagram.com/smartnotes_publication',
            'youtube_url' => 'https://www.youtube.com/@SmartNotesPublication07',
            'linkedin_url' => '#',
            'header_logo' => 'assets/img/logo.png',
            'footer_logo' => 'assets/img/footer-logo.png',
            'mobile_logo' => 'assets/img/logo-mobile.png',
        ];

        foreach ($settings as $k => $v) {
            SiteSetting::set($k, $v);
        }

        // 2. Team Members
        if (TeamMember::count() == 0) {
            TeamMember::create([
                'name' => 'Mr. Sanjaybhai J. Baldaniya',
                'designation' => 'Chairman & Managing Director',
                'image' => 'assets/img/sanjaysir.jpeg',
                'quote' => 'At Smart Notes Publication, I firmly believe that education is not just about gaining knowledge; it is about shaping young minds, inspiring dreams, and building a brighter future.',
                'bio' => 'My vision is to make quality education accessible, meaningful, and engaging for every child. At Smart Notes Publication, we are committed to creating innovative, student-friendly educational books that inspire curiosity, strengthen knowledge, and build confidence.',
                'phone' => '(+91)98241-45453',
                'email' => 'smartnotespublication@gmail.com',
                'sort_order' => 1,
                'is_active' => 1,
            ]);

            TeamMember::create([
                'name' => 'Ms. Sonali S. Das',
                'designation' => 'Senior Executive Administrator',
                'image' => 'assets/img/sonalimam.jpeg',
                'quote' => 'Education is the most powerful weapon which you can use to change the world. We make learning seamless, engaging, and impactful.',
                'bio' => 'Overseeing academic development, editorial precision, and student-first learning pedagogy across all our English and Gujarati medium book publications.',
                'phone' => '(+91) 99798-65666',
                'email' => 'Sevenhigheducationpvtltd@gmail.com',
                'sort_order' => 2,
                'is_active' => 1,
            ]);
        }

        // 3. Sliders (Hero)
        if (Slider::count() == 0) {
            Slider::create([
                'title' => 'The Most Biggest PUBLICATION in the world',
                'highlight_text' => 'PUBLICATION',
                'subtitle' => 'We deliver books all over the world 10,000+ books in stock. Our books are designed to promote holistic development and support academic success.',
                'bg_image' => 'assets/img/bg/hero-bg-1.png',
                'book_image' => 'assets/img/hero/english-group-img.png',
                'button_text' => 'Explore More',
                'button_link' => 'eng-workbook',
                'slider_type' => 'hero',
                'sort_order' => 1,
                'is_active' => 1,
            ]);

            Slider::create([
                'title' => 'Elevate Your Teaching and Learning Experience with SmartNotes Publication',
                'highlight_text' => 'SmartNotes Publication',
                'subtitle' => 'SmartNotes Publication is a learner-centred, blended learning programme that integrates high-quality, NEP-aligned content with state-of-the-art technology.',
                'bg_image' => 'assets/img/bg/hero-bg-2.png',
                'book_image' => 'assets/img/hero/guj-group-img.png',
                'button_text' => 'Explore More',
                'button_link' => 'playgroup-premium',
                'slider_type' => 'hero',
                'sort_order' => 2,
                'is_active' => 1,
            ]);
        }

        // 4. Testimonials
        if (Testimonial::count() == 0) {
            Testimonials_data:
            $testimonials = [
                [
                    'name' => 'Principal Mehta',
                    'designation' => 'Principal',
                    'institution' => 'Bright Star English Medium School',
                    'rating' => 5,
                    'review' => 'SmartNotes educational books have transformed our primary classes. The QR-enabled animated videos make concept retention remarkably simple for children.',
                    'sort_order' => 1,
                ],
                [
                    'name' => 'Mrs. Patel',
                    'designation' => 'Head Teacher',
                    'institution' => 'Saraswati Vidyamandir',
                    'rating' => 5,
                    'review' => 'The Gujarati and English workbook sets are thoroughly aligned with the new NEP guidelines. High quality printing, clear fonts, and captivating illustrations!',
                    'sort_order' => 2,
                ],
                [
                    'name' => 'Mr. Rajesh Sharma',
                    'designation' => 'School Coordinator',
                    'institution' => 'Universal High School',
                    'rating' => 5,
                    'review' => 'Excellent service and prompt delivery. The concept-based learning pedagogy used in Smart Notes books has significantly improved student performance.',
                    'sort_order' => 3,
                ],
            ];

            foreach ($testimonials as $t) {
                Testimonial::create($t);
            }
        }

        // 5. Gallery
        if (Gallery::count() == 0) {
            for ($i = 1; $i <= 6; $i++) {
                Gallery::create([
                    'title' => "School Book Fair & Exhibition 2026 #{$i}",
                    'category' => ($i % 2 == 0) ? 'School Events' : 'Book Fair',
                    'image' => "assets/img/blog/blog-img-1-{$i}.jpg",
                    'sort_order' => $i,
                    'is_active' => 1,
                ]);
            }
        }

        // 6. Services
        if (Service::count() == 0) {
            $services = [
                [
                    'title' => 'School Curriculum Book Publishing',
                    'slug' => 'school-curriculum-publishing',
                    'icon' => 'fa-solid fa-book-open-reader',
                    'short_description' => 'Comprehensive textbook and workbook publications covering Nursery to Class 8 in English & Gujarati medium.',
                    'content' => 'We design NEP-aligned, student-friendly syllabus books focusing on foundational literacy, numeracy, and holistic intellectual development.',
                    'sort_order' => 1,
                ],
                [
                    'title' => 'QR Code Digital Learning Integration',
                    'slug' => 'qr-code-digital-learning',
                    'icon' => 'fa-solid fa-qrcode',
                    'short_description' => 'Every chapter is connected with high quality animated explainer videos accessible via smartphone scan.',
                    'content' => 'Bridging the physical book with immersive digital animation, allowing students to learn difficult concepts visually at home or in class.',
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Teacher Training & Academic Support',
                    'slug' => 'teacher-training-support',
                    'icon' => 'fa-solid fa-chalkboard-user',
                    'short_description' => 'Workshops and teaching guidelines for educators to conduct engaging, activity-based classroom sessions.',
                    'content' => 'Empowering teachers with pedagogical tools, lesson plans, and classroom assessment aids to deliver maximum impact.',
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Bulk School Supply & Dealer Network',
                    'slug' => 'bulk-school-supply',
                    'icon' => 'fa-solid fa-truck-ramp-box',
                    'short_description' => 'Fast delivery across Gujarat and Maharashtra with direct publisher pricing and support for distributors.',
                    'content' => 'Efficient logistics and supply chain ensuring that all textbooks and companion sets reach schools well before academic session beginnings.',
                    'sort_order' => 4,
                ],
            ];

            foreach ($services as $s) {
                Service::create($s);
            }
        }
    }
}


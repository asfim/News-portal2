<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Media;
use App\Models\Author;
use App\Models\News;
use App\Models\Setting;
use Illuminate\Support\Str;

class NewsPortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed default website settings
        Setting::set('site_name', 'দৈনিক জনকথা');
        Setting::set('site_description', 'প্রতিদিনের বিশ্বাসযোগ্য সংবাদ, গভীর বিশ্লেষণ ও মতামত নিয়ে আপনার পাশে।');
        Setting::set('footer_copyright', '© ২০২৬ দৈনিক জনকথা। সর্বস্বত্ব সংরক্ষিত।');
        Setting::set('facebook', 'https://facebook.com/janakatha');
        Setting::set('youtube', 'https://youtube.com/janakatha');
        Setting::set('instagram', 'https://instagram.com/janakatha');
        Setting::set('twitter', 'https://twitter.com/janakatha');
        Setting::set('homepage_categories', json_encode([
            'bangladesh',
            'politics',
            'world',
            'business',
            'sports',
            'entertainment',
            'lifestyle'
        ]));

        // Seed default Pages for the footer (প্রতিষ্ঠান)
        \App\Models\Page::firstOrCreate(['slug' => 'about-us'], ['title' => 'আমাদের সম্পর্কে', 'content' => 'দৈনিক জনকথা একটি নির্ভরযোগ্য সংবাদ মাধ্যম। আমরা সর্বদা সত্য ও নিরপেক্ষ সংবাদ পরিবেশনে অঙ্গীকারবদ্ধ।', 'status' => true]);
        \App\Models\Page::firstOrCreate(['slug' => 'contact'], ['title' => 'যোগাযোগ', 'content' => 'আমাদের সাথে যোগাযোগ করতে ইমেইল করুন: contact@janakatha.com', 'status' => true]);
        \App\Models\Page::firstOrCreate(['slug' => 'terms-of-service'], ['title' => 'শর্তাবলী', 'content' => 'আমাদের ওয়েবসাইটের ব্যবহারের শর্তাবলী বিস্তারিত জানতে এখানে পড়ুন।', 'status' => true]);
        \App\Models\Page::firstOrCreate(['slug' => 'privacy-policy'], ['title' => 'গোপনীয়তা নীতি', 'content' => 'আপনার তথ্যের গোপনীয়তা রক্ষায় আমরা প্রতিশ্রুতিবদ্ধ।', 'status' => true]);

        // Get or create author profile
        $author = Author::first();
        if (!$author) {
            $author = Author::create([
                'name' => 'নিজস্ব প্রতিবেদক',
                'username' => 'staff_reporter',
                'email' => 'reporter@newsportal.com',
                'phone' => '+8801700000000',
                'designation' => 'সিনিয়র রিপোর্টার',
                'bio' => 'দৈনিক জনকথা এর নিজস্ব সংবাদকর্মী।',
                'status' => true
            ]);
        }

        // 2. Define categories
        $categoriesData = [
            ['name' => 'বাংলাদেশ', 'slug' => 'bangladesh'],
            ['name' => 'রাজনীতি', 'slug' => 'politics'],
            ['name' => 'বিশ্ব', 'slug' => 'world'],
            ['name' => 'বাণিজ্য', 'slug' => 'business'],
            ['name' => 'খেলা', 'slug' => 'sports'],
            ['name' => 'বিনোদন', 'slug' => 'entertainment'],
            ['name' => 'জীবনযাপন', 'slug' => 'lifestyle'],
            ['name' => 'মতামত', 'slug' => 'opinion'],
            ['name' => 'চাকরি', 'slug' => 'jobs']
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::updateOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'status' => true]
            );
        }

        // Define subcategories under parent category slugs
        $subcategoriesData = [
            'bangladesh' => [
                ['name' => 'জাতীয়', 'slug' => 'national'],
                ['name' => 'অপরাধ', 'slug' => 'crime'],
                ['name' => 'জেলা সংবাদ', 'slug' => 'district-news']
            ],
            'politics' => [
                ['name' => 'দলীয় সংবাদ', 'slug' => 'party-news'],
                ['name' => 'জাতীয় রাজনীতি', 'slug' => 'national-politics']
            ],
            'world' => [
                ['name' => 'এশিয়া', 'slug' => 'asia'],
                ['name' => 'মধ্যপ্রাচ্য', 'slug' => 'middle-east'],
                ['name' => 'ইউরোপ ও আমেরিকা', 'slug' => 'europe-america']
            ],
            'business' => [
                ['name' => 'ব্যাংক ও বিমা', 'slug' => 'banking-insurance'],
                ['name' => 'শেয়ার বাজার', 'slug' => 'stock-market']
            ],
            'sports' => [
                ['name' => 'ক্রিকেট', 'slug' => 'cricket'],
                ['name' => 'ফুটবল', 'slug' => 'football']
            ],
            'entertainment' => [
                ['name' => 'চলচ্চিত্র', 'slug' => 'cinema'],
                ['name' => 'টেলিভিশন', 'slug' => 'television']
            ],
            'lifestyle' => [
                ['name' => 'স্বাস্থ্য', 'slug' => 'health'],
                ['name' => 'ভ্রমণ', 'slug' => 'travel']
            ]
        ];

        $subcategories = [];
        foreach ($subcategoriesData as $parentSlug => $subs) {
            $parent = $categories[$parentSlug] ?? null;
            if ($parent) {
                foreach ($subs as $sub) {
                    $subcategories[$sub['slug']] = Category::updateOrCreate(
                        ['slug' => $sub['slug']],
                        [
                            'parent_id' => $parent->id,
                            'name' => $sub['name'],
                            'status' => true
                        ]
                    );
                }
            }
        }

        // 3. Seed premium Unsplash images in the Media table
        $mediaUrls = [
            // Original images
            'metro_rail' => 'https://images.unsplash.com/photo-1556559322-b5071efadc88?q=80&w=800&auto=format&fit=crop',
            'padma_bridge' => 'https://images.unsplash.com/photo-1596422846543-c5c6ff18a1a3?q=80&w=800&auto=format&fit=crop',
            'sylhet_flood' => 'https://images.unsplash.com/photo-1547683905-f686c993aae5?q=80&w=800&auto=format&fit=crop',
            'dhaka_traffic' => 'https://images.unsplash.com/photo-1540959733332-eab4deceeaf7?q=80&w=800&auto=format&fit=crop',
            'ec_roadmap' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?q=80&w=800&auto=format&fit=crop',
            'parliament' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=800&auto=format&fit=crop',
            'earthquake' => 'https://images.unsplash.com/photo-1594897030264-ab7d87efc473?q=80&w=800&auto=format&fit=crop',
            'us_election' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?q=80&w=800&auto=format&fit=crop',
            'remittance' => 'https://images.unsplash.com/photo-1580519542036-c47de6196ba5?q=80&w=800&auto=format&fit=crop',
            'stock_market' => 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?q=80&w=800&auto=format&fit=crop',
            'garments' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?q=80&w=800&auto=format&fit=crop',
            'cricket_win' => 'https://images.unsplash.com/photo-1624526261182-ab3d814372e9?q=80&w=800&auto=format&fit=crop',
            'football_clash' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=800&auto=format&fit=crop',
            'bangladesh_cricket' => 'https://images.unsplash.com/photo-1531415080290-bc98513989fe?q=80&w=800&auto=format&fit=crop',
            'cannes_cinema' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=800&auto=format&fit=crop',
            'tv_webseries' => 'https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?q=80&w=800&auto=format&fit=crop',
            'healthy_food' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=800&auto=format&fit=crop',
            'sajek_travel' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=800&auto=format&fit=crop',
            'cox_bazar' => 'https://images.unsplash.com/photo-1589308078059-be1415eab4c3?q=80&w=800&auto=format&fit=crop',
            'climate_change' => 'https://images.unsplash.com/photo-1611273426858-450d8e3c9fce?q=80&w=800&auto=format&fit=crop',
            'job_exam' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800&auto=format&fit=crop',

            // New images for additional subcategory news
            'school_building' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop',
            'gas_pipeline' => 'https://images.unsplash.com/photo-1611273426858-450d8e3c9fce?q=80&w=800&auto=format&fit=crop',
            'flyover' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?q=80&w=800&auto=format&fit=crop',
            'crime_scene' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=800&auto=format&fit=crop',
            'police_patrol' => 'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?q=80&w=800&auto=format&fit=crop',
            'drug_bust' => 'https://images.unsplash.com/photo-1589994965851-a8f479c573a9?q=80&w=800&auto=format&fit=crop',
            'cyber_crime' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=800&auto=format&fit=crop',
            'court_gavel' => 'https://images.unsplash.com/photo-1589391886645-d51941baf7fb?q=80&w=800&auto=format&fit=crop',
            'road_accident' => 'https://images.unsplash.com/photo-1582560475093-ba66accbc424?q=80&w=800&auto=format&fit=crop',
            'chittagong_port' => 'https://images.unsplash.com/photo-1494412574643-ff11b0a5eb19?q=80&w=800&auto=format&fit=crop',
            'rangpur_field' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800&auto=format&fit=crop',
            'rajshahi_mango' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?q=80&w=800&auto=format&fit=crop',
            'barishal_river' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=800&auto=format&fit=crop',
            'rally_crowd' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?q=80&w=800&auto=format&fit=crop',
            'press_conference' => 'https://images.unsplash.com/photo-1504711434969-e33886168d6c?q=80&w=800&auto=format&fit=crop',
            'opposition_rally' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?q=80&w=800&auto=format&fit=crop',
            'election_booth' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?q=80&w=800&auto=format&fit=crop',
            'mayor_office' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=800&auto=format&fit=crop',
            'budget_session' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?q=80&w=800&auto=format&fit=crop',
            'reform_commission' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=800&auto=format&fit=crop',
            'student_politics' => 'https://images.unsplash.com/photo-1523050854058-8df90110c8f1?q=80&w=800&auto=format&fit=crop',
            'china_economy' => 'https://images.unsplash.com/photo-1547981609-4b6bfe67ca0b?q=80&w=800&auto=format&fit=crop',
            'india_pm' => 'https://images.unsplash.com/photo-1532375810709-75b1da00537c?q=80&w=800&auto=format&fit=crop',
            'myanmar_refugee' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=800&auto=format&fit=crop',
            'south_korea_tech' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800&auto=format&fit=crop',
            'gaza_conflict' => 'https://images.unsplash.com/photo-1542228262-e1b9db6f82c1?q=80&w=800&auto=format&fit=crop',
            'saudi_hajj' => 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?q=80&w=800&auto=format&fit=crop',
            'iran_nuclear' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?q=80&w=800&auto=format&fit=crop',
            'turkey_economy' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?q=80&w=800&auto=format&fit=crop',
            'uae_expo' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=800&auto=format&fit=crop',
            'uk_pm' => 'https://images.unsplash.com/photo-1529655683826-aba9b3e77383?q=80&w=800&auto=format&fit=crop',
            'eu_summit' => 'https://images.unsplash.com/photo-1519567241046-7f570eee3ce6?q=80&w=800&auto=format&fit=crop',
            'canada_immigration' => 'https://images.unsplash.com/photo-1503614472-8c93d56e92ce?q=80&w=800&auto=format&fit=crop',
            'brazil_amazon' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?q=80&w=800&auto=format&fit=crop',
            'bank_interest' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=800&auto=format&fit=crop',
            'mobile_banking' => 'https://images.unsplash.com/photo-1563986768609-322da13575f2?q=80&w=800&auto=format&fit=crop',
            'insurance_policy' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=800&auto=format&fit=crop',
            'ipo_market' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?q=80&w=800&auto=format&fit=crop',
            'commodity_price' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?q=80&w=800&auto=format&fit=crop',
            'mutual_fund' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop',
            'bond_market' => 'https://images.unsplash.com/photo-1642543348745-03b1219733d9?q=80&w=800&auto=format&fit=crop',
            'cricket_test' => 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=800&auto=format&fit=crop',
            'cricket_ipl' => 'https://images.unsplash.com/photo-1531415074968-036ba1b575da?q=80&w=800&auto=format&fit=crop',
            'cricket_women' => 'https://images.unsplash.com/photo-1578432014316-48b448d79d68?q=80&w=800&auto=format&fit=crop',
            'football_bpl' => 'https://images.unsplash.com/photo-1574629810360-7efad52da0dc?q=80&w=800&auto=format&fit=crop',
            'football_world' => 'https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?q=80&w=800&auto=format&fit=crop',
            'football_premier' => 'https://images.unsplash.com/photo-1522778119026-d647f0596c20?q=80&w=800&auto=format&fit=crop',
            'football_transfer' => 'https://images.unsplash.com/photo-1553778263-73a83bab9b0c?q=80&w=800&auto=format&fit=crop',
            'dhallywood_movie' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800&auto=format&fit=crop',
            'bollywood_star' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800&auto=format&fit=crop',
            'film_festival' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800&auto=format&fit=crop',
            'oscar_award' => 'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?q=80&w=800&auto=format&fit=crop',
            'tv_drama' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?q=80&w=800&auto=format&fit=crop',
            'tv_reality' => 'https://images.unsplash.com/photo-1578269174936-2709b6aeb913?q=80&w=800&auto=format&fit=crop',
            'tv_news_channel' => 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=800&auto=format&fit=crop',
            'tv_eid_program' => 'https://images.unsplash.com/photo-1574375927938-d5a98e8d7e28?q=80&w=800&auto=format&fit=crop',
            'mental_health' => 'https://images.unsplash.com/photo-1493836512294-502baa1986e2?q=80&w=800&auto=format&fit=crop',
            'yoga_fitness' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800&auto=format&fit=crop',
            'diabetes_care' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=800&auto=format&fit=crop',
            'dengue_mosquito' => 'https://images.unsplash.com/photo-1611601322175-ef8fd1c22e45?q=80&w=800&auto=format&fit=crop',
            'sundarban_tour' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?q=80&w=800&auto=format&fit=crop',
            'bandarbans' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=800&auto=format&fit=crop',
            'sreemangal_tea' => 'https://images.unsplash.com/photo-1582793988951-9aed5509eb97?q=80&w=800&auto=format&fit=crop',
        ];

        $mediaIds = [];
        foreach ($mediaUrls as $name => $url) {
            $media = Media::updateOrCreate(
                ['filename' => $name . '.jpg'],
                [
                    'name' => $name,
                    'path' => $url,
                    'size' => 102400,
                    'mime_type' => 'image/jpeg',
                    'alt_text' => $name,
                    'uploaded_by' => 1
                ]
            );
            $mediaIds[$name] = $media->id;
        }

        // Helper function to create news
        $createNews = function ($categorySlug, $title, $short, $mediaKey, $flags = [], $videoUrl = null) use ($categories, $subcategories, $mediaIds, $author) {
            $slug = Str::slug($title, '-');
            // Ensure unique slug
            $originalSlug = $slug;
            $count = 1;
            while (News::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $subcategorySlug = null;
            if (isset($flags['subcategory'])) {
                $subcategorySlug = $flags['subcategory'];
                unset($flags['subcategory']);
            }

            News::updateOrCreate(
                ['slug' => $slug],
                array_merge([
                    'category_id' => $categories[$categorySlug]->id,
                    'subcategory_id' => $subcategorySlug && isset($subcategories[$subcategorySlug]) ? $subcategories[$subcategorySlug]->id : null,
                    'author_id' => $author->id,
                    'title' => $title,
                    'short_description' => $short,
                    'content' => $short . ' এটি সংবাদটির পূর্ণ বিবরণ। এখানে বিস্তারিত তথ্য থাকবে যা পাঠককে সংবাদের গভীর বিশ্লেষণে সাহায্য করবে। প্রকল্প বা ঘটনার পটভূমি এবং আগামী দিনের কার্যক্রম সম্পর্কেও আলোকপাত করা হবে।',
                    'featured_image' => $mediaIds[$mediaKey] ?? null,
                    'thumbnail' => $mediaIds[$mediaKey] ?? null,
                    'video_url' => $videoUrl,
                    'status' => 'published',
                    'publish_at' => now(),
                    'views' => rand(100, 5000),
                ], $flags)
            );
        };

        $createNews('sports', 'বিশ্বকাপের প্রস্তুতি ম্যাচে শ্রীলঙ্কাকে হারিয়ে শুভ সূচনা বাংলাদেশের', 'অফ-স্পিন ও টপ অর্ডার ব্যাটারদের দারুণ নৈপুণ্যে বিশ্বকাপের প্রথম অফিশিয়াল প্রস্তুতি ম্যাচে শ্রীলঙ্কার বিপক্ষে সহজ জয় পেয়েছে বাংলাদেশ।', 'bangladesh_cricket', ['is_latest' => true, 'subcategory' => 'cricket']);
        $createNews('sports', 'বাংলাদেশ-পাকিস্তান টেস্ট সিরিজে রোমাঞ্চকর ড্র, সাকিবের সেঞ্চুরি', 'রাওয়ালপিন্ডিতে অনুষ্ঠিত প্রথম টেস্টে সাকিব আল হাসানের অপরাজিত সেঞ্চুরিতে ড্রয়ে শেষ হয়েছে ম্যাচ। শেষ দিনে বাংলাদেশকে জয়ের কাছাকাছি নিয়ে গিয়েছিলেন সাকিব, কিন্তু সময়ের অভাবে জয় হাতছাড়া হয়।', 'cricket_test', ['subcategory' => 'cricket']);
        $createNews('sports', 'আইপিএলে রেকর্ড দামে নিলামে উঠলেন বাংলাদেশের তরুণ পেসার', 'ইন্ডিয়ান প্রিমিয়ার লিগের (আইপিএল) নিলামে বাংলাদেশের এক তরুণ ফাস্ট বোলার ১২ কোটি রুপিতে বিক্রি হয়ে নতুন রেকর্ড গড়েছেন। তার ১৫০+ কিলোমিটার গতির বোলিং একাধিক ফ্র্যাঞ্চাইজির নজর কেড়েছে।', 'cricket_ipl', ['is_latest' => true, 'subcategory' => 'cricket']);
        $createNews('sports', 'নারী ক্রিকেটে বাংলাদেশের অসাধারণ জয়, এশিয়া কাপের সেমিফাইনালে', 'নারী এশিয়া কাপের গ্রুপ পর্বে নেপাল ও মালয়েশিয়াকে হারিয়ে সেমিফাইনালে উঠেছে বাংলাদেশ নারী ক্রিকেট দল। অধিনায়কের অলরাউন্ড পারফরম্যান্স দলকে জয়ের পথে নিয়ে গেছে।', 'cricket_women', ['subcategory' => 'cricket']);

        // ───────────────────────────────────────────────
        // খেলা > ফুটবল (football) — 5 news
        // ───────────────────────────────────────────────
        $createNews('sports', 'উয়েফা চ্যাম্পিয়ন্স লিগের রোমাঞ্চকর ফাইনালে জয়ী রিয়াল মাদ্রিদ', 'লন্ডনের ওয়েম্বলি স্টেডিয়ামে অনুষ্ঠিত চ্যাম্পিয়ন্স লিগের ফাইনালে বরুশিয়া ডর্টমুন্ডকে ২-০ গোলে হারিয়ে ১৫ বারের মতো ইউরোপের সেরা ক্লাবের মুকুট জিতল রিয়াল মাদ্রিদ।', 'football_clash', ['subcategory' => 'football']);
        $createNews('sports', 'বাংলাদেশ প্রিমিয়ার লিগে মোহামেডানের দুর্দান্ত জয়, শিরোপার দৌড়ে এগিয়ে', 'বাংলাদেশ প্রিমিয়ার লিগের (বিপিএল) গুরুত্বপূর্ণ ম্যাচে আবাহনী লিমিটেডকে ৩-১ গোলে হারিয়ে পয়েন্ট তালিকার শীর্ষে উঠেছে মোহামেডান স্পোর্টিং ক্লাব। নাইজেরিয়ান স্ট্রাইকারের হ্যাটট্রিক ম্যাচের পরিণতি নির্ধারণ করে।', 'football_bpl', ['is_latest' => true, 'subcategory' => 'football']);
        $createNews('sports', 'ফিফা বিশ্বকাপ বাছাইপর্বে বাংলাদেশের গুরুত্বপূর্ণ জয়', 'ফিফা বিশ্বকাপ ২০২৬ বাছাইপর্বের দ্বিতীয় রাউন্ডে বাংলাদেশ জাতীয় ফুটবল দল তুর্কমেনিস্তানকে ২-০ গোলে হারিয়ে গুরুত্বপূর্ণ তিন পয়েন্ট ঘরে তুলেছে। এই জয় বাংলাদেশের পরবর্তী রাউন্ডে ওঠার সম্ভাবনাকে জীবিত রেখেছে।', 'football_world', ['subcategory' => 'football']);
        $createNews('sports', 'ইংলিশ প্রিমিয়ার লিগে আর্সেনালের শিরোপা জয়, ২০ বছর পর ট্রফি ঘরে', 'ইংলিশ প্রিমিয়ার লিগের শেষ ম্যাচডে-তে ম্যানচেস্টার সিটিকে পেছনে ফেলে ২০ বছর পর লিগ শিরোপা জিতেছে আর্সেনাল। এমিরেটস স্টেডিয়ামে হাজার হাজার সমর্থক উদযাপনে মেতে ওঠে।', 'football_premier', ['is_latest' => true, 'subcategory' => 'football']);
        $createNews('sports', 'বার্সেলোনা থেকে পিএসজিতে যাচ্ছেন তারকা স্ট্রাইকার, রেকর্ড ট্রান্সফার ফি', 'স্প্যানিশ জায়ান্ট বার্সেলোনার তরুণ স্ট্রাইকার রেকর্ড ২০০ মিলিয়ন ইউরো ট্রান্সফার ফি তে প্যারিস সেইন্ট-জার্মে (পিএসজি) যোগ দিচ্ছেন। এটি ফুটবল ইতিহাসের তৃতীয় সর্বোচ্চ ট্রান্সফার ফি হিসেবে রেকর্ড হয়েছে।', 'football_transfer', ['subcategory' => 'football']);

        // ───────────────────────────────────────────────
        // বিনোদন > চলচ্চিত্র (cinema) — 5 news
        // ───────────────────────────────────────────────
        $createNews('entertainment', 'কান চলচ্চিত্র উৎসবে প্রশংসিত বাংলাদেশী তরুণ নির্মাতার স্বল্পদৈর্ঘ্য চলচ্চিত্র', 'বিশ্বের অন্যতম মর্যাদাপূর্ণ কান চলচ্চিত্র উৎসবের শর্ট ফিল্ম কর্নারে বাংলাদেশের এক তরুণ নির্মাতার চলচ্চিত্র প্রদর্শিত ও প্রশংসিত হয়েছে।', 'cannes_cinema', ['subcategory' => 'cinema']);
        $createNews('entertainment', 'ঢালিউডে মুক্তি পেল মুক্তিযুদ্ধভিত্তিক মহাকাব্যিক চলচ্চিত্র, দর্শকদের ব্যাপক সাড়া', 'বাংলাদেশের মুক্তিযুদ্ধের এক অজানা অধ্যায় নিয়ে নির্মিত চলচ্চিত্রটি মুক্তির প্রথম সপ্তাহেই ব্যাপক দর্শক সমাগম ঘটিয়েছে। ভিজ্যুয়াল ইফেক্ট ও অভিনয়ের প্রশংসা করেছেন সমালোচকরা।', 'dhallywood_movie', ['is_latest' => true, 'subcategory' => 'cinema']);
        $createNews('entertainment', 'বলিউডের শীর্ষ তারকার নতুন ছবি ৫০০ কোটি রুপি ক্লাবে, বক্স অফিসে রেকর্ড', 'বলিউডের সুপারস্টার অভিনীত সর্বশেষ অ্যাকশন থ্রিলার চলচ্চিত্রটি বিশ্বব্যাপী বক্স অফিসে ৫০০ কোটি রুপি আয় করে নতুন রেকর্ড গড়েছে। ভারতসহ বাংলাদেশেও ছবিটি দুর্দান্ত ব্যবসা করেছে।', 'bollywood_star', ['subcategory' => 'cinema']);
        $createNews('entertainment', 'ঢাকা আন্তর্জাতিক চলচ্চিত্র উৎসবে ৫০টি দেশের চলচ্চিত্র প্রদর্শন', 'ঢাকা আন্তর্জাতিক চলচ্চিত্র উৎসবের (ডিআইএফএফ) এবারের আসরে ৫০টি দেশের ২০০-র বেশি চলচ্চিত্র প্রদর্শিত হচ্ছে। উৎসবে বাংলাদেশি চলচ্চিত্র নির্মাতাদের জন্য বিশেষ মাস্টারক্লাসও অনুষ্ঠিত হচ্ছে।', 'film_festival', ['is_latest' => true, 'subcategory' => 'cinema']);
        $createNews('entertainment', 'অস্কারে বাংলাদেশের প্রতিনিধিত্ব করবে যে চলচ্চিত্র, আশা জাগাচ্ছে', 'আন্তর্জাতিক ফিচার ফিল্ম বিভাগে অস্কারের জন্য বাংলাদেশের পক্ষ থেকে একটি চলচ্চিত্র মনোনয়ন দেওয়া হয়েছে। ছবিটি ইতিমধ্যে একাধিক আন্তর্জাতিক চলচ্চিত্র উৎসবে পুরস্কৃত হয়েছে।', 'oscar_award', ['subcategory' => 'cinema']);

        // ───────────────────────────────────────────────
        // বিনোদন > টেলিভিশন (television) — 5 news
        // ───────────────────────────────────────────────
        $createNews('entertainment', 'নতুন ওটিটি প্ল্যাটফর্মে মুক্তি পাচ্ছে রহস্য ঘরানার ওয়েব সিরিজ', 'দেশের জনপ্রিয় এক ওটিটি প্ল্যাটফর্মে চলতি সপ্তাহের শেষে মুক্তি পেতে যাচ্ছে একটি রহস্য-রোমাঞ্চ ঘরানার থ্রিলার ওয়েব সিরিজ। দর্শকদের মধ্যে এটি নিয়ে দারুণ কৌতূহল দেখা গেছে।', 'tv_webseries', ['subcategory' => 'television']);
        $createNews('entertainment', 'টেলিভিশনে নতুন ধারাবাহিক নাটক শুরু, মুক্তিযুদ্ধের পটভূমিতে প্রেমকাহিনী', 'দেশের শীর্ষ একটি টেলিভিশন চ্যানেলে শুরু হচ্ছে মুক্তিযুদ্ধের পটভূমিতে নির্মিত একটি ধারাবাহিক নাটক। জনপ্রিয় দুই অভিনেতা-অভিনেত্রীর জুটিতে নাটকটি দর্শকদের মুগ্ধ করবে বলে আশা করছেন নির্মাতারা।', 'tv_drama', ['is_latest' => true, 'subcategory' => 'television']);
        $createNews('entertainment', 'রিয়েলিটি শো "বাংলাদেশ আইডল" নতুন মৌসুমে ফিরছে, রেজিস্ট্রেশন শুরু', 'জনপ্রিয় সংগীত প্রতিযোগিতা অনুষ্ঠান "বাংলাদেশ আইডল"-এর নতুন মৌসুমের জন্য সারাদেশে অডিশন রেজিস্ট্রেশন শুরু হয়েছে। এবারের মৌসুমে বিচারক হিসেবে থাকছেন দেশ-বিদেশের বিখ্যাত শিল্পীরা।', 'tv_reality', ['subcategory' => 'television']);
        $createNews('entertainment', 'বাংলাদেশি টিভি চ্যানেলের আন্তর্জাতিক সম্প্রচার শুরু, ইউরোপ ও আমেরিকায়', 'দেশের একটি বেসরকারি টেলিভিশন চ্যানেল ইউরোপ ও উত্তর আমেরিকায় স্যাটেলাইট সম্প্রচার শুরু করেছে। এতে প্রবাসী বাংলাদেশিরা সরাসরি দেশের খবর ও বিনোদন উপভোগ করতে পারবেন।', 'tv_news_channel', ['subcategory' => 'television']);
        $createNews('entertainment', 'ঈদ উপলক্ষে টেলিভিশনে বিশেষ অনুষ্ঠানমালার আয়োজন, তারকাদের উপস্থিতি', 'আসন্ন ঈদুল আজহা উপলক্ষে দেশের প্রধান টেলিভিশন চ্যানেলগুলো বিশেষ অনুষ্ঠানমালার আয়োজন করেছে। সংগীত, নাটক, টেলিফিল্ম ও গেম শো নিয়ে সাজানো হয়েছে ঈদের অনুষ্ঠানসূচি।', 'tv_eid_program', ['is_latest' => true, 'subcategory' => 'television']);

        // ───────────────────────────────────────────────
        // জীবনযাপন > স্বাস্থ্য (health) — 5 news
        // ───────────────────────────────────────────────
        $createNews('lifestyle', 'হৃদরোগের ঝুঁকি কমাতে প্রতিদিনের খাদ্যতালিকায় যেসব পরিবর্তন জরুরি', 'চিকিৎসকদের মতে, প্রক্রিয়াজাত খাবার ও অতিরিক্ত লবণ পরিহার করে তাজা শাকসবজি ও ফলমূল বেশি খেলে হৃদরোগের ঝুঁকি বহুলাংশে কমানো সম্ভব।', 'healthy_food', ['subcategory' => 'health']);
        $createNews('lifestyle', 'মানসিক স্বাস্থ্য সচেতনতায় জাতীয় প্রচারণা শুরু, বিশেষজ্ঞদের পরামর্শ', 'স্বাস্থ্য মন্ত্রণালয় সারাদেশে মানসিক স্বাস্থ্য সচেতনতা প্রচারণা শুরু করেছে। বিশেষজ্ঞরা বলছেন, বিষণ্নতা ও উদ্বেগজনিত সমস্যায় সময়মতো পেশাদার সাহায্য নেওয়া জীবন বদলে দিতে পারে।', 'mental_health', ['is_latest' => true, 'subcategory' => 'health']);
        $createNews('lifestyle', 'প্রতিদিন ৩০ মিনিট যোগব্যায়ামে কমবে ডায়াবেটিসের ঝুঁকি, গবেষণায় প্রমাণ', 'নতুন একটি আন্তর্জাতিক গবেষণায় দেখা গেছে, প্রতিদিন মাত্র ৩০ মিনিট যোগব্যায়াম বা হালকা ব্যায়াম করলে টাইপ-২ ডায়াবেটিসের ঝুঁকি ৪০ শতাংশ পর্যন্ত কমে যায়। বাংলাদেশের চিকিৎসকরাও এই পরামর্শকে সমর্থন করেছেন।', 'yoga_fitness', ['subcategory' => 'health']);
        $createNews('lifestyle', 'দেশে ডায়াবেটিস রোগীর সংখ্যা দ্রুত বাড়ছে, সচেতনতা জরুরি', 'বাংলাদেশে ডায়াবেটিস রোগীর সংখ্যা ১ কোটি ছাড়িয়ে গেছে বলে জানিয়েছে ডায়াবেটিক সমিতি। অনিয়ন্ত্রিত খাদ্যাভ্যাস, শারীরিক নিষ্ক্রিয়তা ও মানসিক চাপকে প্রধান কারণ হিসেবে চিহ্নিত করা হয়েছে।', 'diabetes_care', ['is_latest' => true, 'subcategory' => 'health']);
        $createNews('lifestyle', 'ডেঙ্গু প্রতিরোধে জাতীয় কর্মসূচি শুরু, সারাদেশে মশক নিধন অভিযান', 'ডেঙ্গু মৌসুম শুরুর আগেই সরকার সারাদেশে ব্যাপক মশক নিধন অভিযান শুরু করেছে। স্বাস্থ্য অধিদপ্তর জানিয়েছে, এবার ডেঙ্গু আক্রান্তের সংখ্যা কমাতে গত বছরের চেয়ে ৫ গুণ বেশি ওষুধ ছিটানো হবে।', 'dengue_mosquito', ['subcategory' => 'health']);

        // ───────────────────────────────────────────────
        // জীবনযাপন > ভ্রমণ (travel) — 5 news
        // ───────────────────────────────────────────────
        $createNews('lifestyle', 'শীতের আমেজে পর্যটকদের উপচে পড়া ভিড়ে মুখরিত সাজেক ভ্যালি', 'পাহাড়ে হালকা কুয়াশা ও মেঘের মিতালী উপভোগ করতে রাঙ্গামাটির সাজেক ভ্যালিতে হাজার হাজার পর্যটকের ঢল নেমেছে। কটেজগুলোর প্রায় সবগুলোই আগে থেকে বুকড হয়ে গেছে।', 'sajek_travel', ['subcategory' => 'travel']);
        $createNews('lifestyle', 'পর্যটকদের উপচে পড়া ভিড়ে মুখরিত কক্সবাজার সমুদ্র সৈকত', 'সাপ্তাহিক ছুটি ও উৎসবের আমেজে বিশ্বের দীর্ঘতম সমুদ্র সৈকত কক্সবাজারে লাখো পর্যটকের সমাগম ঘটেছে। আবাসিক হোটেল ও মোটেলগুলোতে তিল ধারণের ঠাঁই নেই।', 'cox_bazar', ['subcategory' => 'travel']);
        $createNews('lifestyle', 'সুন্দরবনে পর্যটন মৌসুম শুরু, রয়েল বেঙ্গল টাইগার দেখতে ভিড়', 'বিশ্বের সবচেয়ে বড় ম্যানগ্রোভ বন সুন্দরবনে পর্যটন মৌসুম শুরু হয়েছে। রয়েল বেঙ্গল টাইগার, চিত্রা হরিণ ও বিভিন্ন প্রজাতির পাখি দেখতে দেশি-বিদেশি পর্যটকদের আগমন বাড়ছে।', 'sundarban_tour', ['is_latest' => true, 'subcategory' => 'travel']);
        $createNews('lifestyle', 'বান্দরবানের নীলগিরিতে মেঘের সাগরে ভাসছেন পর্যটকরা', 'বান্দরবানের নীলগিরি পর্যটন কেন্দ্রে শীতের মৌসুমে মেঘের সাগর দেখতে হাজার হাজার পর্যটক ভিড় করছেন। সেনাবাহিনী পরিচালিত এই পর্যটন কেন্দ্রে রাত্রিযাপনের জন্য আগে থেকেই বুকিং সম্পন্ন হয়ে যাচ্ছে।', 'bandarbans', ['subcategory' => 'travel']);
        $createNews('lifestyle', 'শ্রীমঙ্গলের চা বাগানে পর্যটকদের ভিড়, নতুন ইকো-রিসোর্ট উদ্বোধন', 'মৌলভীবাজারের শ্রীমঙ্গলে চা বাগান ও লাউয়াছড়া জাতীয় উদ্যান ঘুরতে আসা পর্যটকদের সংখ্যা ব্যাপক বেড়েছে। সম্প্রতি একটি আন্তর্জাতিক মানের ইকো-রিসোর্ট উদ্বোধন করা হয়েছে যেখানে প্রকৃতির মাঝে থাকার ব্যবস্থা আছে।', 'sreemangal_tea', ['is_latest' => true, 'subcategory' => 'travel']);

        // ───────────────────────────────────────────────
        // মতামত (opinion) — no subcategory
        // ───────────────────────────────────────────────
        $createNews('opinion', 'জলবায়ু পরিবর্তনের চ্যালেঞ্জ ও বাংলাদেশের করণীয়', 'বৈশ্বিক গ্রিনহাউস গ্যাস নিঃসরণে বাংলাদেশের দায় নগণ্য হলেও জলবায়ু পরিবর্তনের ফলে সবচেয়ে ক্ষতিগ্রস্ত দেশগুলোর অন্যতম বাংলাদেশ। টেকসই বাঁধ নির্মাণ ও সবুজায়নে বিনিয়োগ বাড়ানো এখন সময়ের দাবি।', 'climate_change');

        // ───────────────────────────────────────────────
        // চাকরি (jobs) — no subcategory
        // ───────────────────────────────────────────────
        $createNews('jobs', 'সরকারি প্রাথমিক বিদ্যালয়ে সহকারী শিক্ষক নিয়োগের চূড়ান্ত ফল প্রকাশ', 'প্রাথমিক শিক্ষা অধিদপ্তর সরকারি প্রাথমিক বিদ্যালয়ের সহকারী শিক্ষক নিয়োগের চূড়ান্ত ফলাফল প্রকাশ করেছে। এতে সারা দেশ থেকে কয়েক হাজার প্রার্থী চূড়ান্তভাবে নির্বাচিত হয়েছেন।', 'job_exam');
    }
}

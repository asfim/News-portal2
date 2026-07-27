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
        Setting::set('homepage_categories', json_encode([
            'bangladesh',
            'politics',
            'world',
            'business',
            'sports',
            'entertainment',
            'lifestyle'
        ]));

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

        // 3. Seed premium Unsplash images in the Media table
        $mediaUrls = [
            'river_ बांध' => 'https://images.unsplash.com/photo-1547683905-f686c993aae5?q=80&w=800&auto=format&fit=crop',
            'grid_electricity' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?q=80&w=800&auto=format&fit=crop',
            'primary_school' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=800&auto=format&fit=crop',
            'oil_market' => 'https://images.unsplash.com/photo-1618042164219-62c820f10723?q=80&w=800&auto=format&fit=crop',
            'metro_rail' => 'https://images.unsplash.com/photo-1474487548417-781cb71495f3?q=80&w=800&auto=format&fit=crop',
            'cricket_practice' => 'https://images.unsplash.com/photo-1531415080290-bc98513989fe?q=80&w=800&auto=format&fit=crop',
            'boat_monsoon' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=800&auto=format&fit=crop',
            'cinema_festival' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=800&auto=format&fit=crop',
            'export_garments' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?q=80&w=800&auto=format&fit=crop',
            'share_market' => 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?q=80&w=800&auto=format&fit=crop',
            'inflation' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?q=80&w=800&auto=format&fit=crop',
            'football_club' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=800&auto=format&fit=crop',
            'runner_record' => 'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?q=80&w=800&auto=format&fit=crop',
            'badminton' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=800&auto=format&fit=crop',
            'sleep_health' => 'https://images.unsplash.com/photo-1511295742364-92767eb89a95?q=80&w=800&auto=format&fit=crop',
            'khichuri_food' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=800&auto=format&fit=crop',
            'app_award' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?q=80&w=800&auto=format&fit=crop',
            'coding_workshop' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?q=80&w=800&auto=format&fit=crop',
            'rural_flood' => 'https://images.unsplash.com/photo-1547683905-f686c993aae5?q=80&w=800&auto=format&fit=crop',
            'farmer_rice' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?q=80&w=800&auto=format&fit=crop',
            'morning_river' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=800&auto=format&fit=crop'
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
        $createNews = function ($categorySlug, $title, $short, $mediaKey, $flags = [], $videoUrl = null) use ($categories, $mediaIds, $author) {
            $slug = Str::slug($title, '-');
            // Ensure unique slug
            $originalSlug = $slug;
            $count = 1;
            while (News::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            News::updateOrCreate(
                ['slug' => $slug],
                array_merge([
                    'category_id' => $categories[$categorySlug]->id,
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

        // 4. Create Hero News
        $createNews('bangladesh', 
            'নদীভাঙন রোধে দশ জেলায় নতুন বাঁধ প্রকল্প অনুমোদন', 
            'পরিকল্পনা কমিশনের সবুজ সংকেতের পর আগামী অর্থবছর থেকে কাজ শুরু হবে বলে জানিয়েছে পানি উন্নয়ন বোর্ড। দীর্ঘমেয়াদী রক্ষণাবেক্ষণ পরিকল্পনা ছাড়া প্রকল্পের সুফল টেকসই হবে না বলছেন বিশেষজ্ঞরা।', 
            'river_ बांध', 
            ['featured_news' => true, 'is_latest' => true]
        );

        $createNews('bangladesh', 
            'বিদ্যুৎ বিভ্রাটে অতিষ্ঠ নগরবাসী, কারণ খুঁজছে বিতরণ সংস্থা', 
            'গ্রীষ্মকালীন তাপমাত্রা বৃদ্ধি এবং হঠাৎ গ্রিডে ত্রুটির কারণে ঢাকা ও পার্শ্ববর্তী এলাকায় বিদ্যুৎ বিভ্রাট চরম আকার ধারণ করেছে। দ্রুত সমস্যা সমাধানের আশ্বাস দিয়েছে বিতরণ বিভাগ।', 
            'grid_electricity', 
            ['is_latest' => true]
        );

        $createNews('bangladesh', 
            'প্রাথমিক শিক্ষক নিয়োগে নতুন বিধিমালার খসড়া প্রকাশ', 
            'নিয়োগ প্রক্রিয়া সহজ করতে এবং স্বচ্ছতা নিশ্চিত করার লক্ষ্যে প্রাথমিক শিক্ষা অধিদপ্তর শিক্ষক নিয়োগ বিধিমালার একটি নতুন খসড়া প্রস্তাব প্রকাশ করেছে।', 
            'primary_school', 
            ['is_latest' => true]
        );

        // 5. Latest News / Recent News List
        $createNews('politics', 
            'মধ্যপ্রাচ্যে উত্তেজনায় জ্বালানি তেলের বাজারে অস্থিরতা', 
            'আন্তর্জাতিক রাজনৈতিক অস্থিরতার প্রভাবে বিশ্ববাজারে অপরিশোধিত জ্বালানি তেলের দাম ব্যপক বৃদ্ধি পেয়েছে, যার ধাক্কা দেশীয় বাজারে লাগতে পারে বলে ধারণা বিশেষজ্ঞদের।', 
            'oil_market'
        );

        $createNews('business', 
            'রপ্তানি আয়ে টানা তৃতীয় মাসে প্রবৃদ্ধি', 
            'নতুন বাজার সম্প্রসারণ ও কাঁচামাল আমদানিতে শুল্ক ছাড়ের সুফল মিলছে বলছেন দেশের পোশাক খাতের সফল রপ্তানিকারকরা।', 
            'export_garments'
        );

        $createNews('bangladesh', 
            'উপকূলীয় অঞ্চলে ভারী বৃষ্টির পূর্বাভাস, সতর্কসংকেত জারি', 
            'উত্তর বঙ্গোপসাগর ও তৎসংলগ্ন উপকূলীয় এলাকায় গভীর সঞ্চরণশীল মেঘমালা সৃষ্টির ফলে দেশের চার বন্দরে সংকেত বাড়ানো হয়েছে।', 
            'boat_monsoon'
        );

        $createNews('business', 
            'স্থানীয় হস্তশিল্পে বিদেশি ক্রেতাদের আগ্রহ বাড়ছে', 
            'দেশের তৈরি ঐতিহ্যবাহী কুটির ও হস্তশিল্প পণ্যের রপ্তানি আয় চলতি অর্থবছরের প্রথম ভাগে আগের চেয়ে অনেক বৃদ্ধি পেয়েছে।', 
            'export_garments'
        );

        $createNews('business', 
            'প্রবাসী আয় এল রেকর্ড পরিমাণে, স্বস্তিতে অর্থনীতি', 
            'কেন্দ্রীয় ব্যাংকের তথ্য অনুযায়ী, চলতি মাসে এ পর্যন্ত রেকর্ড পরিমাণ রেমিট্যান্স পাঠিয়েছেন প্রবাসী বাংলাদেশিরা।', 
            'share_market'
        );

        $createNews('business', 
            'যুব উদ্যোক্তাদের জন্য নতুন ঋণ প্রকল্প ঘোষণা', 
            'স্মার্ট ও স্টার্টআপ ক্যাটাগরিতে যুবকদের ব্যবসা সম্প্রসারণে ব্যাংকগুলো সহজ শর্তে বিনা জামানতে ঋণ প্রকল্প ঘোষণা করেছে।', 
            'app_award'
        );

        // 6. Video News items
        $createNews('bangladesh', 
            'মেট্রোরেলের নতুন রুট নিয়ে প্রতিবেদন', 
            'মতিঝিল থেকে কমলাপুর পর্যন্ত বর্ধিত লাইনে ট্রেন চলাচলের সর্বশেষ আপডেট ও যাত্রী সাধারণের অনুভূতি নিয়ে বিশেষ প্রতিবেদন।', 
            'metro_rail', 
            [], 
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
        );

        $createNews('sports', 
            'এশিয়া কাপের প্রস্তুতি নিয়ে অনুশীলনে দল', 
            'জাতীয় দলের খেলোয়াড়েরা ক্রিকেট একাডেমিতে এশিয়া কাপের কন্ডিশনের সাথে মানিয়ে নিতে ঘাম ঝরাচ্ছেন।', 
            'cricket_practice', 
            [], 
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
        );

        $createNews('lifestyle', 
            'বর্ষায় নৌকা ভ্রমণে পর্যটকদের ভিড়', 
            'টাঙ্গুয়ার হাওর ও চলনবিলে বৃষ্টি উপেক্ষা করে দূর-দূরান্ত থেকে নৌকা ভ্রমণে ছুটে আসছেন হাজারো প্রকৃতিপ্রেমী।', 
            'boat_monsoon', 
            [], 
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
        );

        $createNews('entertainment', 
            'চলচ্চিত্র উৎসবে তরুণ নির্মাতাদের কাজ', 
            'চলমান আন্তর্জাতিক শর্ট ফিল্ম উৎসবে দেশের তরুণ ও প্রতিভাবান নির্মাতাদের দারুণ সাড়া পাওয়া গেছে।', 
            'cinema_festival', 
            [], 
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
        );

        // 7. Business Category News
        $createNews('business', 'শেয়ারবাজারে টানা তৃতীয় দিনের মতো সূচকের ঊর্ধ্বগতি', 'বাজার বিশ্লেষণে দেখা যায় ব্যাংক ও ওষুধ খাতের শেয়ারগুলোর ব্যাপক চাহিদা বাড়ায় সূচক ইতিবাচক ধারায় রয়েছে।', 'share_market');
        $createNews('business', 'জ্বালানি তেলের দাম সমন্বয়ে নতুন নীতিমালা', 'এখন থেকে প্রতি মাসে আন্তর্জাতিক বাজারের সাথে সামঞ্জস্য রেখে স্বয়ংক্রিয়ভাবে দাম নির্ধারণের খসড়া অনুমোদিত।', 'inflation');
        $createNews('business', 'মুদ্রাস্ফীতি নিয়ন্ত্রণে কেন্দ্রীয় ব্যাংকের নতুন পদক্ষেপ কতটা কার্যকর', 'সুদের হার বৃদ্ধি ও ডলারের বিনিময় হার সমন্বয়ে কেন্দ্রীয় ব্যাংকের পদক্ষেপ মূল্যস্ফীতি কমাতে কতটুকু সফল হবে তা নিয়ে চুলচেরা বিশ্লেষণ।', 'inflation');
        $createNews('business', 'ক্ষুদ্র উদ্যোক্তাদের জন্য সহজ শর্তে ঋণ চালু', 'দেশের কুটির ও ক্ষুদ্র শিল্প খাতকে সচল করতে ৫ শতাংশ সুদে রিফাইন্যান্স স্কিম চালু করেছে বাংলাদেশ ব্যাংক।', 'share_market');

        // 8. Sports Category News
        $createNews('sports', 'এশিয়া কাপের আগে ঘরের মাঠে প্রস্তুতি ম্যাচ জিতল বাংলাদেশ', 'ব্যাটিং অর্ডারে পরীক্ষা-নিরীক্ষা চালিয়েও বোলারদের দাপুটে পারফরমেন্সে জয় পেল স্বাগতিক দল।', 'cricket_practice');
        $createNews('sports', 'স্থানীয় লিগে চমক দেখাচ্ছে তৃতীয় বিভাগের নতুন ক্লাব', 'টানা চার জয়ে টেবিলের শীর্ষে উঠে চমক সৃষ্টি করেছে একঝাঁক নতুন তরুণের সমন্বয়ে গড়া এই ক্লাব।', 'football_club');
        $createNews('sports', 'আন্তর্জাতিক মিটে রেকর্ড গড়লেন তরুণ দৌড়বিদ', 'জাতীয় অ্যাথলেটিকস মিটে ১০০ মিটার স্প্রিন্টে দশ সেকেন্ডের কোঠায় নতুন রেকর্ড গড়লেন দেশের এক তরুণ অ্যাথলেট।', 'runner_record');
        $createNews('sports', 'জাতীয় চ্যাম্পিয়নশিপে নতুন মুখের চমক', 'জাতীয় ব্যাডমিন্টন ও টেবিল টেনিস প্রতিযোগিতায় প্রবীণদের হারিয়ে ফাইনালে তরুণদের আধিপত্য।', 'badminton');
        $createNews('sports', 'উপজেলা পর্যায়ে ক্রীড়া অবকাঠামো উন্নয়নে বরাদ্দ বাড়ল', 'তৃণমূল থেকে প্রতিভাবান খেলোয়াড় তুলে আনতে দেশের প্রায় ২০০টি উপজেলায় মিনি স্টেডিয়াম ও খেলার মাঠ নির্মাণ হচ্ছে।', 'football_club');

        // 9. Entertainment & Lifestyle News
        $createNews('entertainment', 'নতুন চলচ্চিত্র উৎসবে দেখানো হবে দশটি স্বল্পদৈর্ঘ্য চলচ্চিত্র', 'তরুণ চলচ্চিত্র নির্মাতাদের উৎসাহিত করতে বিশেষ পুরস্কার প্রদানের পাশাপাশি সপ্তাহব্যাপী এই চলচ্চিত্র প্রদর্শনী শুরু হচ্ছে।', 'cinema_festival');
        $createNews('lifestyle', 'শহুরে ব্যস্ত জীবনে ঘুমের ঘাটতি, কী বলছেন চিকিৎসকরা', 'নগরায়ণের যান্ত্রিক জীবন ও ডিজিটাল ডিভাইসের অতিব্যবহারের ফলে ঘুমের স্বল্পতা দূর করতে কিছু কার্যকরী পরামর্শ।', 'sleep_health');
        $createNews('lifestyle', 'বর্ষায় জনপ্রিয় হয়ে উঠছে খিচুড়ির নতুন সংস্করণ', 'মেঘলা আকাশের সাথে গরম গরম হরেক পদের খিচুড়ির ঐতিহ্যবাহী রান্নার আধুনিক রূপ নিয়ে মুখরোচক প্রতিবেদন।', 'khichuri_food');
        $createNews('entertainment', 'স্থানীয় স্টার্টআপের অ্যাপ পেল আঞ্চলিক পুরস্কার', 'নতুন এআই চ্যাট অ্যাপ উদ্ভাবন করে সিঙ্গাপুরে অনুষ্ঠিত তথ্যপ্রযুক্তি প্রতিযোগিতায় স্বর্ণপদক জিতল বাংলাদেশী দল।', 'app_award');
        $createNews('lifestyle', 'শিক্ষার্থীদের জন্য বিনামূল্যে কোডিং কর্মশালা', 'দেশের স্কুল ও কলেজগামী শিক্ষার্থীদের প্রোগ্রামিং এবং ওয়েব ডেভেলপমেন্টে দক্ষ করতে বিনামূল্যে মাসব্যাপী কর্মশালা শুরু।', 'coding_workshop');

        // 10. Bangladesh Pictures Section
        $createNews('bangladesh', 'বর্ষার জলে ভেসে যাওয়া গ্রামীণ জনপদ', 'টানা বর্ষণ ও পাহাড়ি ঢলে প্লাবিত হয়েছে উত্তরাঞ্চলের চরাঞ্চল। চরম দুর্ভোগে পানিবন্দী মানুষ।', 'rural_flood');
        $createNews('bangladesh', 'ধানক্ষেতে ব্যস্ত কৃষক পরিবার', 'আমন ধানের চারা রোপণের ভরা মৌসুমে সকাল থেকে সন্ধ্যা মাঠের কাজে ব্যস্ত কৃষি নির্ভর পরিবারগুলো।', 'farmer_rice');
        $createNews('bangladesh', 'নদীতীরের সকাল', 'কুয়াশা আর সোনালী রোদের মিষ্টি ছায়ায় দক্ষিণাঞ্চলের নদীতীরে মাঝিদের ব্যস্ততা নিয়ে কিছু চমৎকার দৃশ্যপট।', 'morning_river');
    }
}

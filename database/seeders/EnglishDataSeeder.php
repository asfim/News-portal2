<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Str;

class EnglishDataSeeder extends Seeder
{
    public function run()
    {
        // Create English Categories
        $categories = [
            'Bangladesh' => 'bangladesh-en',
            'Politics' => 'politics-en',
            'World' => 'world-en',
            'Business' => 'business-en',
            'Sports' => 'sports-en',
            'Entertainment' => 'entertainment-en',
        ];

        $catIds = [];
        $order = 1;
        foreach ($categories as $name => $slug) {
            $cat = Category::create([
                'language' => 'en',
                'name' => $name,
                'slug' => $slug,
                'status' => true,
                'sort_order' => $order++,
            ]);
            $catIds[$name] = $cat->id;
        }

        // Create Subcategories for Sports
        $cricketCat = Category::create([
            'language' => 'en',
            'parent_id' => $catIds['Sports'],
            'name' => 'Cricket',
            'slug' => 'cricket-en',
            'status' => true,
            'sort_order' => 1,
        ]);
        $footballCat = Category::create([
            'language' => 'en',
            'parent_id' => $catIds['Sports'],
            'name' => 'Football',
            'slug' => 'football-en',
            'status' => true,
            'sort_order' => 2,
        ]);

        // English News Items
        $newsItems = [
            [
                'title' => 'Bangladesh Announces Final Squad for T20 World Cup',
                'category_id' => $catIds['Sports'],
                'subcategory_id' => $cricketCat->id,
                'is_latest' => true,
                'featured_news' => true,
            ],
            [
                'title' => 'New Economic Policies Introduced to Combat Inflation',
                'category_id' => $catIds['Business'],
                'subcategory_id' => null,
                'is_latest' => true,
                'featured_news' => false,
            ],
            [
                'title' => 'Global Climate Summit Reaches Historic Agreement',
                'category_id' => $catIds['World'],
                'subcategory_id' => null,
                'is_latest' => true,
                'featured_news' => false,
            ],
            [
                'title' => 'Government Approves New Highway Project',
                'category_id' => $catIds['Bangladesh'],
                'subcategory_id' => null,
                'is_latest' => true,
                'featured_news' => true,
                'breaking_news' => true,
            ],
            [
                'title' => 'Local Football Club Wins Regional Championship',
                'category_id' => $catIds['Sports'],
                'subcategory_id' => $footballCat->id,
                'is_latest' => true,
                'featured_news' => false,
            ],
            [
                'title' => 'Award-Winning Director Announces Next Film',
                'category_id' => $catIds['Entertainment'],
                'subcategory_id' => null,
                'is_latest' => true,
                'featured_news' => false,
                'is_gallery' => true,
            ],
            [
                'title' => 'Stock Market Hits Record Highs After Tech Earnings',
                'category_id' => $catIds['Business'],
                'subcategory_id' => null,
                'is_latest' => true,
                'featured_news' => false,
                'breaking_news' => true,
            ],
            [
                'title' => 'Spectacular Sunset Over Dhaka City',
                'category_id' => $catIds['Bangladesh'],
                'subcategory_id' => null,
                'is_latest' => false,
                'featured_news' => false,
                'is_gallery' => true,
            ]
        ];

        foreach ($newsItems as $index => $item) {
            News::create([
                'language' => 'en',
                'category_id' => $item['category_id'],
                'subcategory_id' => $item['subcategory_id'],
                'author_id' => 1,
                'title' => $item['title'],
                'slug' => Str::slug($item['title']) . '-' . rand(100, 999),
                'short_description' => 'This is a detailed short description for ' . strtolower($item['title']) . '. It covers the most important aspects of the news story.',
                'content' => '<p>This is the full content of the news article. It provides in-depth analysis and information regarding the topic at hand. In the real world, this text would be much longer and contain actual facts.</p>',
                'status' => 'published',
                'publish_at' => now()->subMinutes($index * 15),
                'is_latest' => $item['is_latest'] ?? false,
                'featured_news' => $item['featured_news'] ?? false,
                'breaking_news' => $item['breaking_news'] ?? false,
                'is_gallery' => $item['is_gallery'] ?? false,
            ]);
        }
        
        // Add categories to homepage settings so they show up as sections
        $selectedCats = json_decode(\App\Models\Setting::get('homepage_categories', '[]'), true) ?? [];
        $selectedCats = array_unique(array_merge($selectedCats, ['business-en', 'sports-en', 'entertainment-en']));
        \App\Models\Setting::updateOrCreate(
            ['key' => 'homepage_categories'],
            ['value' => json_encode($selectedCats), 'type' => 'array']
        );
    }
}

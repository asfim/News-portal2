<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Get the latest featured news
        $featured = News::published()->featured()->with(['category', 'author', 'featuredImage'])->latest()->first();
        
        // Get recent news
        $recent = News::published()->with(['featuredImage', 'thumbnailImage', 'category'])->latest()->take(15)->get();
        
        // Section Categories (from Settings)
        $selectedCats = json_decode(\App\Models\Setting::get('homepage_categories', '[]'), true) ?? [];
        if (empty($selectedCats)) {
            $selectedCats = Category::where('status', true)->inRandomOrder()->take(4)->pluck('slug')->toArray();
        }

        $categorySections = Category::whereIn('slug', $selectedCats)
            ->with(['news' => function ($query) {
                $query->published()->with(['featuredImage', 'thumbnailImage'])->orderBy('featured_news', 'desc')->latest()->take(9);
            }, 'children'])->get();

        // Video News
        $videoNews = News::published()->with(['featuredImage', 'thumbnailImage'])->whereNotNull('video_url')->latest()->take(6)->get();

        // Get trending news
        $trending = News::published()->trending()->with('category')->take(7)->get();
        
        // Get most read news (order by views)
        $mostRead = News::published()->orderBy('views', 'desc')->with('category')->take(5)->get();

        // Get Latest News (feature flag)
        $latestFeaturedNews = News::published()->with(['featuredImage', 'thumbnailImage'])->where('is_latest', true)->latest()->take(9)->get();

        // Get Breaking News for the sidebar
        $breaking = News::published()->breaking()->latest()->take(12)->get();

        // Get Active Advertisements
        $advertisements = \App\Models\Advertisement::active()->get()->groupBy('placement_key');

        return view('frontend.home', compact('featured', 'recent', 'trending', 'mostRead', 'categorySections', 'videoNews', 'latestFeaturedNews', 'breaking', 'advertisements'));
    }

    public function showNews($slug)
    {
        // Placeholder for single news details
        $news = News::published()->where('slug', $slug)->firstOrFail();
        return view('frontend.news-details', compact('news'));
    }

    public function latestNews()
    {
        $selectedCats = json_decode(\App\Models\Setting::get('homepage_categories', '[]'), true) ?? [];
        if (empty($selectedCats)) {
            $selectedCats = \App\Models\Category::where('status', true)->pluck('slug')->toArray();
        }

        $news = News::published()
            ->whereHas('category', function($q) use ($selectedCats) {
                $q->whereIn('slug', $selectedCats);
            })
            ->latest()
            ->paginate(16);
            
        return view('frontend.latest-news', compact('news'));
    }

    public function quickNews()
    {
        $selectedCats = json_decode(\App\Models\Setting::get('homepage_categories', '[]'), true) ?? [];
        if (empty($selectedCats)) {
            $selectedCats = \App\Models\Category::where('status', true)->pluck('slug')->toArray();
        }

        $categorySections = \App\Models\Category::whereIn('slug', $selectedCats)
            ->with(['news' => function ($query) {
                $query->published()->latest()->take(4);
            }])->get();

        return view('frontend.quick-news', compact('categorySections'));
    }

    public function category($slug)
    {
        // Placeholder for category page
        $category = Category::where('slug', $slug)->where('status', true)->firstOrFail();
        $news = News::published()->where('category_id', $category->id)->latest()->paginate(12);
        return view('frontend.category', compact('category', 'news'));
    }

    public function tag($slug)
    {
        // Placeholder for tag page
        return "Tag Page for: " . $slug;
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ], [
            'email.required' => 'ইমেইল এড্রেস আবশ্যক।',
            'email.email' => 'সঠিক ইমেইল এড্রেস প্রদান করুন।',
            'email.unique' => 'এই ইমেইলটি ইতিপূর্বে সাবস্ক্রাইব করা হয়েছে।',
        ]);

        \App\Models\Newsletter::create([
            'email' => $request->input('email'),
            'status' => true,
        ]);

        return redirect()->back()->with('success', 'আমাদের নিউজলেটারে সাবস্ক্রাইব করার জন্য ধন্যবাদ!');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $news = \App\Models\News::published();
        
        if (!empty($query)) {
            $news->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhereHas('category', function($catQuery) use ($query) {
                      $catQuery->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('subcategory', function($subQuery) use ($query) {
                      $subQuery->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('author', function($authorQuery) use ($query) {
                      $authorQuery->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('tags', function($tagQuery) use ($query) {
                      $tagQuery->where('name', 'like', "%{$query}%");
                  });
            });
        }
        
        $newsResults = $news->latest()->paginate(12)->withQueryString();
        
        return view('frontend.search', compact('newsResults', 'query'));
    }

    public function showPage($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)->where('status', true)->firstOrFail();
        return view('frontend.page', compact('page'));
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'নাম আবশ্যক।',
            'email.required' => 'ইমেইল আবশ্যক।',
            'email.email' => 'সঠিক ইমেইল দিন।',
            'subject.required' => 'বিষয় আবশ্যক।',
            'message.required' => 'বার্তা আবশ্যক।',
        ]);

        \App\Models\Contact::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে। আমরা শীঘ্রই যোগাযোগ করব।');
    }

    public function getCategoryNewsHtml($id, $layoutType)
    {
        $category = Category::findOrFail($id);
        
        $posts = \App\Models\News::published()
            ->with(['featuredImage', 'thumbnailImage'])
            ->where(function($q) use ($id) {
                $q->where('category_id', $id)
                  ->orWhere('subcategory_id', $id);
            })
            ->orderBy('featured_news', 'desc')
            ->latest()
            ->take(9)
            ->get();

        $rawLayout = str_replace('-', '_', $layoutType ?: 'layout_1');
        $allowedLayouts = ['layout_1', 'layout_2', 'sports', 'standard'];
        $layout = in_array($rawLayout, $allowedLayouts) ? $rawLayout : 'layout_1';

        $viewName = 'frontend.partials.layouts.' . $layout;
        
        if (view()->exists($viewName)) {
            return view($viewName, ['posts' => $posts, 'categoryId' => $id])->render();
        }
        
        return '<div class="text-center py-4 text-danger">Layout not found</div>';
    }
}


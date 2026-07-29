<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    /**
     * Display a listing of the news articles.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $authorId = $request->input('author_id');
        $status = $request->input('status');

        $query = News::with(['category', 'author', 'featuredImage'])->latest();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($authorId) {
            $query->where('author_id', $authorId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $news = $query->paginate(15)->withQueryString();

        // Load filters
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->get();
        $authors = Author::orderBy('name', 'asc')->get();

        return view('admin.news.index', compact('news', 'categories', 'authors'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->get();
        $tags = Tag::where('status', true)->orderBy('name', 'asc')->get();
        $authors = Author::where('status', true)->orderBy('name', 'asc')->get();

        return view('admin.news.create', compact('categories', 'tags', 'authors'));
    }

    /**
     * Store a newly created news article in storage.
     */
    public function store(NewsRequest $request)
    {
        $data = $request->validated();

        // Convert flags checkbox inputs to boolean values
        $data['breaking_news'] = $request->has('breaking_news');
        $data['featured_news'] = $request->has('featured_news');
        $data['trending_news'] = $request->has('trending_news');
        $data['editor_choice'] = $request->has('editor_choice');
        $data['is_latest'] = $request->has('is_latest');
        $data['is_gallery'] = $request->has('is_gallery');

        if ($data['is_latest']) {
            $latestCount = News::where('is_latest', true)->count();
            if ($latestCount >= 9) {
                return redirect()->back()->withInput()->with('error', 'সর্বোচ্চ ৯টি নিউজ Latest হিসেবে রাখা যাবে। দয়া করে আগে অন্য কোনো নিউজ থেকে Latest অপশনটি বন্ধ করুন।');
            }
        }

        if ($data['breaking_news']) {
            $breakingCount = News::where('breaking_news', true)->count();
            if ($breakingCount >= 11) {
                return redirect()->back()->withInput()->with('error', 'সর্বোচ্চ ১১টি নিউজ Breaking News হিসেবে রাখা যাবে। দয়া করে আগে অন্য কোনো নিউজ থেকে Breaking News অপশনটি বন্ধ করুন।');
            }
        }

        if ($data['trending_news'] && $data['category_id'] == 5) {
            $existingTrending = News::where('trending_news', true)
                ->where('category_id', 5)
                ->orderBy('created_at', 'asc')->get();
            if ($existingTrending->count() >= 7) {
                $excessCount = $existingTrending->count() - 6;
                foreach ($existingTrending->take($excessCount) as $oldItem) {
                    $oldItem->update(['trending_news' => false]);
                }
            }
        }

        if ($data['featured_news'] && $data['category_id'] == 5) {
            $existingFeatured = News::where('featured_news', true)
                ->where('category_id', 5)
                ->orderBy('created_at', 'asc')->get();
            if ($existingFeatured->count() >= 4) {
                $excessCount = $existingFeatured->count() - 3;
                foreach ($existingFeatured->take($excessCount) as $oldItem) {
                    $oldItem->update(['featured_news' => false]);
                }
            }
        }

        // Handle publish_at scheduling
        if ($data['status'] === 'scheduled' && !empty($data['publish_at'])) {
            $data['publish_at'] = Carbon::parse($data['publish_at']);
        } elseif ($data['status'] === 'published') {
            $data['publish_at'] = now();
        }

        if ($request->hasFile('video_upload')) {
            $path = $request->file('video_upload')->store('news_videos', 'public');
            $data['video_url'] = '/storage/' . $path;
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                if (count($gallery) >= 4) break;
                $path = $file->store('news_galleries', 'public');
                $gallery[] = '/storage/' . $path;
            }
            $data['gallery_images'] = $gallery;
        }

        $news = News::create($data);

        // Sync tags pivot relationship
        if (!empty($data['tags'])) {
            $news->tags()->sync($data['tags']);
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news)
    {
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->get();
        $tags = Tag::where('status', true)->orderBy('name', 'asc')->get();
        $authors = Author::where('status', true)->orderBy('name', 'asc')->get();

        // Load subcategories under the current news parent category
        $subcategories = Category::where('parent_id', $news->category_id)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.news.edit', compact('news', 'categories', 'tags', 'authors', 'subcategories'));
    }

    /**
     * Update the specified news article in storage.
     */
    public function update(NewsRequest $request, News $news)
    {
        $data = $request->validated();

        // Convert flags
        $data['breaking_news'] = $request->has('breaking_news');
        $data['featured_news'] = $request->has('featured_news');
        $data['trending_news'] = $request->has('trending_news');
        $data['editor_choice'] = $request->has('editor_choice');
        $data['is_latest'] = $request->has('is_latest');
        $data['is_gallery'] = $request->has('is_gallery');

        if ($data['is_latest']) {
            $latestCount = News::where('is_latest', true)->where('id', '!=', $news->id)->count();
            if ($latestCount >= 9) {
                return redirect()->back()->withInput()->with('error', 'সর্বোচ্চ ৯টি নিউজ Latest হিসেবে রাখা যাবে। দয়া করে আগে অন্য কোনো নিউজ থেকে Latest অপশনটি বন্ধ করুন।');
            }
        } else {
            $data['is_latest'] = false;
        }

        if ($data['breaking_news']) {
            $breakingCount = News::where('breaking_news', true)->where('id', '!=', $news->id)->count();
            if ($breakingCount >= 11) {
                return redirect()->back()->withInput()->with('error', 'সর্বোচ্চ ১১টি নিউজ Breaking News হিসেবে রাখা যাবে। দয়া করে আগে অন্য কোনো নিউজ থেকে Breaking News অপশনটি বন্ধ করুন।');
            }
        } else {
            $data['breaking_news'] = false;
        }

        if ($data['trending_news']) {
            if ($data['category_id'] == 5) {
                $existingTrending = News::where('trending_news', true)
                    ->where('category_id', 5)
                    ->where('id', '!=', $news->id)->orderBy('created_at', 'asc')->get();
                if ($existingTrending->count() >= 7) {
                    $excessCount = $existingTrending->count() - 6;
                    foreach ($existingTrending->take($excessCount) as $oldItem) {
                        $oldItem->update(['trending_news' => false]);
                    }
                }
            }
        } else {
            $data['trending_news'] = false;
        }

        if ($data['featured_news']) {
            if ($data['category_id'] == 5) {
                $existingFeatured = News::where('featured_news', true)
                    ->where('category_id', 5)
                    ->where('id', '!=', $news->id)->orderBy('created_at', 'asc')->get();
                if ($existingFeatured->count() >= 4) {
                    $excessCount = $existingFeatured->count() - 3;
                    foreach ($existingFeatured->take($excessCount) as $oldItem) {
                        $oldItem->update(['featured_news' => false]);
                    }
                }
            }
        } else {
            $data['featured_news'] = false;
        }

        // Handle publish_at scheduling
        if ($data['status'] === 'scheduled' && !empty($data['publish_at'])) {
            $data['publish_at'] = Carbon::parse($data['publish_at']);
        } elseif ($data['status'] === 'published') {
            $data['publish_at'] = now();
        }

        if ($request->hasFile('video_upload')) {
            $path = $request->file('video_upload')->store('news_videos', 'public');
            $data['video_url'] = '/storage/' . $path;
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = $news->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $file) {
                if (count($gallery) >= 4) break;
                $path = $file->store('news_galleries', 'public');
                $gallery[] = '/storage/' . $path;
            }
            $data['gallery_images'] = $gallery;
        }

        $news->update($data);

        // Sync tags
        if (isset($data['tags'])) {
            $news->tags()->sync($data['tags']);
        } else {
            $news->tags()->sync([]);
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified news article from storage.
     */
    public function destroy(News $news)
    {
        $news->delete(); // Soft deletes

        return redirect()->route('admin.news.index')
            ->with('success', 'Article deleted successfully.');
    }

    /**
     * Retrieve subcategories of a category via AJAX.
     */
    public function getSubcategories(Category $category)
    {
        $subcategories = Category::where('parent_id', $category->id)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }
}

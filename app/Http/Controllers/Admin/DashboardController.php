<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use App\Models\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // 1. Statistics Cards
        $stats = [
            'total_news' => News::count(),
            'published_news' => News::where('status', 'published')->count(),
            'draft_news' => News::where('status', 'draft')->count(),
            'pending_news' => News::where('status', 'pending')->count(),
            'total_categories' => Category::count(),
            'total_authors' => Author::count(),
            'total_users' => User::count(),
            'total_comments' => Comment::count(),
            'total_views' => News::sum('views'),
            'todays_views' => View::whereDate('viewed_date', Carbon::today())->count(),
            'total_ads' => Advertisement::count(),
        ];

        // 2. Recent Lists (Eager Loading relations to avoid N+1 queries)
        $recentNews = News::with(['category', 'author'])
            ->latest()
            ->take(5)
            ->get();

        $recentComments = Comment::with(['user', 'news'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Analytics Aggregates (Last 7 Days)
        $last7Days = collect(range(6, 0))->map(function ($daysBack) {
            return Carbon::today()->subDays($daysBack)->format('Y-m-d');
        });

        // Daily News Published
        $newsByDayRaw = News::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('status', 'published')
            ->where('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('date')
            ->pluck('count', 'date');

        $newsPublishedChart = $last7Days->map(function ($date) use ($newsByDayRaw) {
            return $newsByDayRaw->get($date, 0);
        });

        // Daily Page Views
        $viewsByDayRaw = View::select('viewed_date as date', DB::raw('count(*) as count'))
            ->where('viewed_date', '>=', Carbon::today()->subDays(6))
            ->groupBy('viewed_date')
            ->pluck('count', 'date');

        $pageViewsChart = $last7Days->map(function ($date) use ($viewsByDayRaw) {
            return $viewsByDayRaw->get($date, 0);
        });

        // User registrations
        $registrationsByDayRaw = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('date')
            ->pluck('count', 'date');

        $userRegistrationsChart = $last7Days->map(function ($date) use ($registrationsByDayRaw) {
            return $registrationsByDayRaw->get($date, 0);
        });

        // Popular Categories (categories with most published news)
        $popularCategories = Category::withCount(['news' => function ($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('news_count', 'desc')
            ->take(5)
            ->get();

        // Most Viewed News
        $mostViewedNews = News::orderBy('views', 'desc')
            ->take(5)
            ->get();

        $chartLabels = $last7Days->map(function ($date) {
            return Carbon::parse($date)->format('M d');
        });

        return view('admin.dashboard', compact(
            'stats',
            'recentNews',
            'recentComments',
            'chartLabels',
            'newsPublishedChart',
            'pageViewsChart',
            'userRegistrationsChart',
            'popularCategories',
            'mostViewedNews'
        ));
    }
}

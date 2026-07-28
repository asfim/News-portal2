@php
    // We expect $posts to be passed in to this partial
    // Filter posts to only include those with featured_news = true for the hero section
    $featuredPosts = $posts->where('featured_news', 1);
    $heroPost = $featuredPosts->first();

    // Get ONLY articles where trending_news = 1 for this category
    // Assuming $categoryId is passed to know which category this belongs to
    // If not passed, we can fall back to the first post's category_id, but it's safer to pass $categoryId
    $categoryId = $categoryId ?? ($posts->first()->category_id ?? null);
    
    $sidebarPosts = \App\Models\News::published()
        ->when($categoryId, function ($query, $categoryId) {
            $query->where(function($q) use ($categoryId) {
                $q->where('category_id', $categoryId)
                  ->orWhere('subcategory_id', $categoryId);
            });
        })
        ->where('trending_news', 1)
        ->latest()
        ->take(7)
        ->get();

    // Get bottom grid posts (excluding hero post so no duplicate card in main area)
    $usedIds = collect([$heroPost ? $heroPost->id : null])->filter();
    $bottomLimit = 3;
    $mainBottomPosts = $featuredPosts
        ->reject(function ($p) use ($usedIds) {
            return $usedIds->contains($p->id);
        })
        ->take($bottomLimit);

    // Fallback: If no featured/trending, just take latest
    if (!$heroPost) {
        $heroPost = $posts->first();
        $usedIds = collect([$heroPost ? $heroPost->id : null])->filter();
    }
    
    if ($mainBottomPosts->isEmpty()) {
        $mainBottomPosts = $posts->reject(function ($p) use ($usedIds) {
            return $usedIds->contains($p->id);
        })->take($bottomLimit);
        $usedIds = $usedIds->merge($mainBottomPosts->pluck('id'));
    }

    if ($sidebarPosts->isEmpty()) {
        $sidebarPosts = $posts->reject(function ($p) use ($usedIds) {
            return $usedIds->contains($p->id);
        })->take(7);
    }
@endphp

<div class="sports-layout">
    <!-- Main Content (Left) -->
    <div class="sports-main">
        @if ($heroPost)
            <div class="sports-hero-card">
                <a href="{{ route('news.show', $heroPost->slug) }}">
                    <figure class="sports-hero-img">
                        @if ($heroPost->thumbnailImage || $heroPost->featuredImage)
                            <x-news-thumbnail :news="$heroPost" classes="w-100 h-100 object-fit-cover" />
                        @else
                            <div class="art art1 w-100 h-100"></div>
                        @endif
                        @if ($heroPost->video_url)
                            <div class="play-indicator"></div>
                        @endif
                        <div class="sports-hero-overlay">
                            <h4>{{ $heroPost->title }}</h4>
                            <span class="time">{{ $heroPost->created_at->diffForHumans() }}</span>
                        </div>
                    </figure>
                </a>
            </div>
        @endif

        @if ($mainBottomPosts->count() > 0)
            <div class="sports-bottom-grid">
                @foreach ($mainBottomPosts as $post)
                    <div class="sports-grid-card">
                        <div class="card-img">
                            <a href="{{ route('news.show', $post->slug) }}">
                                @if ($post->thumbnailImage || $post->featuredImage)
                                    <x-news-thumbnail :news="$post" classes="w-100 h-100 object-fit-cover" />
                                @else
                                    <div class="art art{{ $loop->iteration + 1 }} w-100 h-100"></div>
                                @endif
                                @if ($post->video_url)
                                    <div class="play-indicator"></div>
                                @endif
                            </a>
                        </div>
                        <div class="card-content">
                            <h5><a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a></h5>
                            <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Sidebar Content (Right) -->
    <div class="sports-sidebar">
        @if ($sidebarPosts->count() > 0)
            <div class="sports-side-list">
                @foreach ($sidebarPosts as $post)
                    <div class="sports-side-card">
                        <div class="card-content">
                            <h6><a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a></h6>
                            <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="card-img">
                            <a href="{{ route('news.show', $post->slug) }}">
                                @if ($post->thumbnailImage || $post->featuredImage)
                                    <x-news-thumbnail :news="$post" classes="w-100 h-100 object-fit-cover" />
                                @else
                                    <div class="art art{{ $loop->iteration + 3 }} w-100 h-100"></div>
                                @endif
                                @if ($post->video_url)
                                    <div class="play-indicator"></div>
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

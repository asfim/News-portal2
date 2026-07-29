<div class="category-section-layout">
    <!-- Row 1: 2 Columns (Title & description left, Image right) -->
    @php
        $featuredPosts = $posts->where('featured_news', 1);
        // If not enough featured, just take the first few
        if ($featuredPosts->isEmpty()) {
            $featuredPosts = $posts;
        }
        $row1Posts = $featuredPosts->take(2);
        $row2Posts = $featuredPosts->slice(2, 3);
    @endphp
    @if ($row1Posts->count() > 0)
        <div class="cat-row-1">
            @foreach ($row1Posts as $post)
                <div class="cat-card-style-1">
                    <div class="card-content">
                        <h4><a href="{{ route('news.show', $post->slug) }}">{{ $post->translated_title }}</a>
                        </h4>
                        <p>{{ Str::limit($post->translated_short_description, 120) }}</p>
                        <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="card-img">
                        <a href="{{ route('news.show', $post->slug) }}">
                            @if ($post->thumbnailImage || $post->featuredImage)
                                <x-news-thumbnail :news="$post"
                                    classes="w-100 h-100 object-fit-cover" />
                            @else
                                <div class="art art{{ $loop->iteration }} w-100 h-100"></div>
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

    <!-- Row 2: 3 Columns (Image top, Title below) -->
    @if ($row2Posts->count() > 0)
        <div class="cat-row-2">
            @foreach ($row2Posts as $post)
                <div class="cat-card-style-2">
                    <div class="card-img">
                        <a href="{{ route('news.show', $post->slug) }}">
                            @if ($post->thumbnailImage || $post->featuredImage)
                                <x-news-thumbnail :news="$post"
                                    classes="w-100 h-100 object-fit-cover" />
                            @else
                                <div class="art art{{ $loop->iteration + 2 }} w-100 h-100"></div>
                            @endif
                            @if ($post->video_url)
                                <div class="play-indicator"></div>
                            @endif
                        </a>
                    </div>
                    <div class="card-content">
                        <h4><a href="{{ route('news.show', $post->slug) }}">{{ $post->translated_title }}</a>
                        </h4>
                        <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Row 3: 3 Columns (Text-only news) -->
    @php
        $row3Posts = $featuredPosts->slice(5, 3);
    @endphp
    @if ($row3Posts->count() > 0)
        <div class="cat-row-3">
            @foreach ($row3Posts as $post)
                <div class="cat-card-style-2">
                    <div class="card-img">
                        <a href="{{ route('news.show', $post->slug) }}">
                            @if ($post->thumbnailImage || $post->featuredImage)
                                <x-news-thumbnail :news="$post" classes="w-100 h-100 object-fit-cover" />
                            @else
                                <div class="art art{{ $loop->iteration + 5 }} w-100 h-100"></div>
                            @endif
                            @if ($post->video_url)
                                <div class="play-indicator"></div>
                            @endif
                        </a>
                    </div>
                    <div class="card-content">
                        <h4><a href="{{ route('news.show', $post->slug) }}">{{ $post->translated_title }}</a></h4>
                        <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@php
    $layout2Posts = $posts->take(5);
    $centerPost = $layout2Posts->first();
    $leftPosts = $layout2Posts->slice(1, 2);
    $rightPosts = $layout2Posts->slice(3, 2);
@endphp

@if($centerPost)
    <div class="layout-2-grid">
        <!-- Left Side -->
        <div class="layout-2-side">
            @foreach($leftPosts as $post)
                <div class="layout-2-grid-item">
                    <div class="card-img">
                        <a href="{{ route('news.show', $post->slug) }}">
                            @if ($post->thumbnailImage || $post->featuredImage)
                                <x-news-thumbnail :news="$post" classes="w-100 h-100 object-fit-cover" />
                            @else
                                <div class="art art{{ $loop->iteration }} w-100 h-100"></div>
                            @endif
                            @if ($post->video_url)
                                <div class="play-indicator"></div>
                            @endif
                        </a>
                    </div>
                    <h4><a href="{{ route('news.show', $post->slug) }}">{{ $post->translated_title }}</a></h4>
                </div>
            @endforeach
        </div>
        
        <!-- Center Big -->
        <div class="layout-2-center">
            <div class="card-img">
                <a href="{{ route('news.show', $centerPost->slug) }}">
                    @if ($centerPost->featuredImage || $centerPost->thumbnailImage)
                        <x-news-thumbnail :news="$centerPost" classes="w-100 h-100 object-fit-cover" />
                    @else
                        <div class="art art3 w-100 h-100"></div>
                    @endif
                    @if ($centerPost->video_url)
                        <div class="play-indicator"></div>
                    @endif
                </a>
            </div>
            <div class="card-content">
                <h3><a href="{{ route('news.show', $centerPost->slug) }}">{{ $centerPost->translated_title }}</a></h3>
                <p>{{ Str::limit($centerPost->translated_short_description, 180) }}</p>
                <span class="time">{{ $centerPost->created_at->diffForHumans() }}</span>
            </div>
        </div>
        
        <!-- Right Side -->
        <div class="layout-2-side">
            @foreach($rightPosts as $post)
                <div class="layout-2-grid-item">
                    <div class="card-img">
                        <a href="{{ route('news.show', $post->slug) }}">
                            @if ($post->thumbnailImage || $post->featuredImage)
                                <x-news-thumbnail :news="$post" classes="w-100 h-100 object-fit-cover" />
                            @else
                                <div class="art art{{ $loop->iteration + 4 }} w-100 h-100"></div>
                            @endif
                            @if ($post->video_url)
                                <div class="play-indicator"></div>
                            @endif
                        </a>
                    </div>
                    <h4><a href="{{ route('news.show', $post->slug) }}">{{ $post->translated_title }}</a></h4>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="text-center py-4 text-secondary">কোনো খবর পাওয়া যায়নি।</div>
@endif

@php
    $layout1Posts = $posts->take(5);
    $mainPost = $layout1Posts->first();
    $sidePosts = $layout1Posts->slice(1);
@endphp

@if($mainPost)
    <div class="layout-1-grid">
        <div class="layout-1-main">
            <div class="card-img">
                <a href="{{ route('news.show', $mainPost->slug) }}">
                    @if ($mainPost->featuredImage || $mainPost->thumbnailImage)
                        <x-news-thumbnail :news="$mainPost" classes="w-100 h-100 object-fit-cover" />
                    @else
                        <div class="art art1 w-100 h-100"></div>
                    @endif
                    @if ($mainPost->video_url)
                        <div class="play-indicator"></div>
                    @endif
                </a>
            </div>
            <div class="card-content">
                <h3><a href="{{ route('news.show', $mainPost->slug) }}">{{ $mainPost->title }}</a></h3>
                <p>{{ Str::limit($mainPost->short_description, 180) }}</p>
                <span class="time">{{ $mainPost->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @if($sidePosts->count() > 0)
            <div class="layout-1-sidebar">
                @foreach($sidePosts as $post)
                    <div class="layout-1-list-item">
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
                            <h4><a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a></h4>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@else
    <div class="text-center py-4 text-secondary">কোনো খবর পাওয়া যায়নি।</div>
@endif

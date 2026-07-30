<!-- BREAKING NEWS TICKER -->
@php
    $breakingNews = \App\Models\News::published()->breaking()->latest()->take(5)->get();
@endphp
@if($breakingNews->isNotEmpty())
<div class="breaking-news-bar py-2">
    <div class="container-fluid px-lg-5">
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center bg-danger text-white px-3 py-1 rounded-pill me-3 shadow-sm flex-shrink-0" style="font-size: 0.85rem; font-weight: 700;">
                <span class="live-pulse bg-white me-2"></span>
                <span>@lang('messages.breaking_news')</span>
            </div>
            <div class="ticker-wrap flex-grow-1">
                <div class="ticker-move fw-semibold" style="font-size: 16px;">
                    @foreach($breakingNews as $news)
                        <span class="me-5">
                            <i class="fa-solid fa-angle-right text-danger me-1"></i> 
                            <a href="{{ route('news.show', $news->slug) }}" class="text-decoration-none hover-danger">{{ $news->translated_title }}</a>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

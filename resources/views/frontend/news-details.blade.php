@extends('layouts.app')

@section('title', $news->translated_title . ' | NewsHub Pro')

@section('content')
<main class="container-fluid px-lg-5 py-4">

    <!-- ARTICLE READING SECTION -->
    <section id="article" class="pt-4 border-top" data-aos="fade-up">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Reading Progress Bar -->
                <div id="readingProgress" class="position-fixed top-0 start-0 bg-danger" style="height: 4px; z-index: 2050; width: 0%;"></div>

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb m-0 small fw-medium">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="fa-solid fa-house me-1"></i> @lang('messages.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('category', $news->category->slug) }}" class="text-decoration-none text-muted">{{ $news->category->translated_name }}</a></li>
                        <li class="breadcrumb-item active text-danger" aria-current="page">@lang('messages.current_news')</li>
                    </ol>
                </nav>

                <span class="badge bg-danger text-uppercase px-3 py-2 rounded-pill fw-bold mb-3">{{ $news->category->translated_name }}</span>
                
                <h1 class="fw-black display-5 mb-3 lh-sm" style="font-size: calc(1.8rem + 1.5vw);">
                    {{ $news->translated_title }}
                </h1>
                <p class="fs-5 text-muted mb-4 fw-medium">
                    {{ $news->translated_short_description }}
                </p>

                <div class="glass-card p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($news->author->name) }}&background=random" class="rounded-circle object-fit-cover" style="width: 50px; height: 50px;" alt="{{ $news->author->name }}">
                        <div>
                            <h6 class="fw-bold m-0">{{ $news->author->name }}</h6>
                            <small class="text-muted">@lang('messages.reporter_dhaka')</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 text-muted small">
                        <span><i class="fa-regular fa-calendar me-1"></i> {{ $news->created_at->format('d F Y') }}</span>
                        <span><i class="fa-regular fa-eye me-1"></i> {{ number_format($news->views) }} @lang('messages.views_count')</span>
                    </div>
                </div>

                <!-- Reading Accessibility Actions -->
                <div class="d-flex align-items-center justify-content-end p-2 mb-4 rounded-3 bg-body-tertiary border">
                    <div class="d-flex gap-2 align-items-center">
                        <span class="small fw-bold text-muted me-1">@lang('messages.share')</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" style="width:32px; height:32px; padding: 4px;"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news->translated_title) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-circle" style="width:32px; height:32px; padding: 4px;"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($news->translated_title . ' ' . request()->fullUrl()) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-circle" style="width:32px; height:32px; padding: 4px;"><i class="fa-brands fa-whatsapp"></i></a>
                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="window.print()"><i class="fa-solid fa-print"></i> @lang('messages.print')</button>
                    </div>
                </div>

                <div class="rounded-4 overflow-hidden mb-4 position-relative">
                    @if($news->video_url)
                        @if(str_starts_with($news->video_url, '/storage/'))
                            <video src="{{ asset($news->video_url) }}" controls class="w-100" style="max-height: 500px; background: #000;"></video>
                        @elseif(str_contains($news->video_url, 'youtube.com') || str_contains($news->video_url, 'youtu.be'))
                            @php
                                $videoId = '';
                                if (str_contains($news->video_url, 'v=')) {
                                    parse_str(parse_url($news->video_url, PHP_URL_QUERY), $vars);
                                    $videoId = $vars['v'] ?? '';
                                } elseif (str_contains($news->video_url, 'youtu.be/')) {
                                    $videoId = basename(parse_url($news->video_url, PHP_URL_PATH));
                                }
                            @endphp
                            @if($videoId)
                                <div class="ratio ratio-16x9">
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video" allowfullscreen></iframe>
                                </div>
                            @endif
                        @endif
                    @elseif($news->featuredImage)
                        <img src="{{ $news->featuredImage->path }}" class="w-100 img-fluid" alt="{{ $news->translated_title }}">
                        @if($news->featuredImage->caption)
                            <div class="p-2 bg-dark text-white small">{{ $news->featuredImage->caption }}</div>
                        @endif
                    @else
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=1200&auto=format&fit=crop" class="w-100 img-fluid" alt="Fallback">
                    @endif
                </div>

                <article id="articleBody" class="article-content fs-5 lh-lg" style="color: var(--nh-text); font-size: 19px;">
                    {!! $news->translated_content !!}
                </article>
                
                <!-- Tags -->
                @if($news->tags->count() > 0)
                <div class="mt-5 border-top pt-4">
                    <h5 class="fw-bold mb-3">@lang('messages.tags')</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($news->tags as $tag)
                            <a href="#" class="badge bg-secondary text-white text-decoration-none px-3 py-2 rounded-pill">#{{ $tag->translated_name }}</a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                {!! renderAdSlot('inside_content', 'w-100 mt-4 mb-4') !!}
                
                <!-- Bottom Related News -->
                <div class="mt-5 border-top pt-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="fw-extrabold m-0 border-start border-4 border-danger ps-2">@lang('messages.more_news')</h4>
                        <a href="{{ route('news.quick') }}" class="text-danger fw-bold text-decoration-none small">@lang('messages.see_all') <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    
                    <div class="row g-3">
                        @php
                            $bottomRelated = \App\Models\News::published()
                                ->where('category_id', $news->category_id)
                                ->where('id', '!=', $news->id)
                                ->latest()
                                ->take(3)
                                ->get();
                        @endphp
                        
                        @forelse($bottomRelated as $related)
                            <div class="col-md-4 col-sm-6">
                                <div class="glass-card h-100 overflow-hidden d-flex flex-column hover-lift">
                                    <div class="img-zoom-container position-relative ratio ratio-16x9">
                                        <x-news-thumbnail :news="$related" classes="object-fit-cover" />
                                    </div>
                                    <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                                        <h6 class="fw-bold mb-2 line-clamp-2">
                                            <a href="{{ route('news.show', $related->slug) }}" class="text-reset text-decoration-none hover-danger">{{ $related->translated_title }}</a>
                                        </h6>
                                        <span class="text-muted small" style="font-size: 0.75rem;"><i class="fa-regular fa-clock me-1"></i> {{ $related->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-muted small">@lang('messages.no_related_news')</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 90px;">
                    
                    {!! renderAdSlot('sidebar_top', 'w-100 mb-4') !!}
                    
                    <div class="glass-card p-4 mb-4">
                        <h5 class="fw-extrabold mb-3 border-start border-3 border-danger ps-2">@lang('messages.related_news')</h5>
                        <div class="d-flex flex-column gap-3">
                            @foreach(\App\Models\News::published()->where('category_id', $news->category_id)->where('id', '!=', $news->id)->latest()->take(4)->get() as $related)
                            <a href="{{ route('news.show', $related->slug) }}" class="text-reset text-decoration-none border-bottom pb-2">
                                <h6 class="fw-bold hover-danger m-0">{{ $related->translated_title }}</h6>
                                <small class="text-muted">{{ $related->created_at->diffForHumans() }}</small>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection

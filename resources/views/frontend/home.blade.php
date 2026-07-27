@extends('layouts.app')

@section('title', 'NewsHub Pro | খবরের সাথে, সবসময়')

@section('content')
    <main class="container-fluid px-lg-5 py-4">

        <!-- HERO SECTION (Split Screen) -->
        <section class="row g-4 mb-5" data-aos="fade-up">
            <div class="col-lg-8">
                @if ($featured)
                    <div class="hero-banner position-relative overflow-hidden rounded-4 shadow-lg h-100"
                        style="min-height: 520px;">
                        <div class="img-zoom-container w-100 h-100 position-absolute top-0 start-0">
                            <x-news-thumbnail :news="$featured" classes="w-100 h-100 object-fit-cover" />
                        </div>
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background: linear-gradient(180deg, rgba(7,11,18,0) 20%, rgba(7,11,18,0.95) 100%);"></div>

                        <!-- Floating Glass Card Overlay -->
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 p-md-4 m-3 m-md-4 rounded-4 border text-white" style="background: rgba(11, 18, 32, 0.45) !important; border: 1px solid rgba(255, 255, 255, 0.1) !important;">
                            <span class="badge bg-danger text-uppercase px-3 py-2 rounded-pill fw-bold mb-2">{{ $featured->category->name }}</span>
                            <h2 class="fw-extrabold display-6 mb-2 text-white lh-sm" style="font-size: calc(1.3rem + 1.2vw);">
                                <a href="{{ route('news.show', $featured->slug) }}" class="text-white text-decoration-none hover-danger">{{ $featured->title }}</a>
                            </h2>
                            <p class="text-light opacity-75 d-none d-md-block mb-3 fs-6 line-clamp-2">{{ $featured->short_description }}</p>
                            <div class="d-flex align-items-center text-white-50 gap-3 border-top border-secondary pt-2" style="font-size: 0.85rem !important; opacity: 1 !important;">
                                <span><i class="fa-solid fa-user-pen text-danger me-1"></i> {{ $featured->author->name }}</span>
                                <span><i class="fa-regular fa-clock me-1"></i> {{ $featured->created_at->diffForHumans() }}</span>
                                <span><i class="fa-regular fa-eye me-1"></i> {{ number_format($featured->views) }} পঠিত</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- LIVE TIMELINE PANEL -->
            <div class="col-lg-4">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h3 class="h5 fw-extrabold m-0 d-flex align-items-center gap-2">
                            <span class="live-pulse"></span> লাইভ আপডেট
                        </h3>
                        <span class="badge bg-danger-subtle text-danger border border-danger fs-7">সরাসরি</span>
                    </div>

                    <div class="timeline-container position-relative ps-3"
                        style="border-left: 2px dashed var(--nh-border);">
                        @foreach ($recent->take(4) as $index => $news)
                            <div class="timeline-item {{ $loop->last ? '' : 'mb-4' }} position-relative">
                                <span
                                    class="position-absolute top-0 start-0 translate-middle p-1 {{ $index === 0 ? 'bg-danger' : 'bg-secondary' }} border border-light rounded-circle"
                                    style="left: -13px !important;"></span>
                                <small
                                    class="badge bg-secondary text-white mb-1 font-en">{{ $news->created_at->format('h:i A') }}</small>
                                <h4 class="h6 fw-bold mb-1"><a href="{{ route('news.show', $news->slug) }}"
                                        class="text-reset text-decoration-none hover-danger">{{ $news->title }}</a></h4>
                                @if ($index === 0)
                                    <p class="text-muted small m-0">{{ Str::limit($news->short_description, 60) }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- LATEST FEATURED NEWS GRID -->
        @if (isset($latestFeaturedNews) && $latestFeaturedNews->count() > 0)
            <section class="mb-5 pb-4 border-bottom" data-aos="fade-up">
                <div class="row g-4">

                    <!-- Left Column: 2 News -->
                    <div class="col-lg-3 border-end pe-lg-4">
                        <div class="d-flex flex-column h-100 gap-4">
                            @foreach ($latestFeaturedNews->slice(1, 2) as $newsItem)
                                <div class="{{ $loop->last ? '' : 'border-bottom pb-4' }}">
                                    <div class="row g-2 mb-2">
                                        <div class="col-7">
                                            <h4 class="h6 fw-bold mb-0 lh-base"><a
                                                    href="{{ route('news.show', $newsItem->slug) }}"
                                                    class="text-reset text-decoration-none hover-danger">{{ $newsItem->title }}</a>
                                            </h4>
                                        </div>
                                        <div class="col-5">
                                            <div class="ratio ratio-4x3 bg-light rounded overflow-hidden">
                                                <x-news-thumbnail :news="$newsItem"
                                                    classes="w-100 h-100 object-fit-cover" />
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted small m-0 mb-2">{{ Str::limit($newsItem->short_description, 80) }}
                                    </p>
                                    <span class="text-muted small" style="font-size: 0.75rem;"><i
                                            class="fa-regular fa-clock me-1"></i>
                                        {{ $newsItem->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Center Column: 1 Main Feature + 2 Bottom -->
                    <div class="col-lg-6 px-lg-4 border-end">
                        @if ($mainFeature = $latestFeaturedNews->first())
                            <div class="mb-4">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-7">
                                        @if (!empty($mainFeature->gallery_images) && count($mainFeature->gallery_images) >= 4)
                                            <div class="row g-1">
                                                @foreach (array_slice($mainFeature->gallery_images, 0, 4) as $img)
                                                    <div class="col-6">
                                                        <div class="ratio ratio-4x3 bg-light">
                                                            <img src="{{ asset($img) }}" alt="Gallery Image"
                                                                class="w-100 h-100 object-fit-cover rounded">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="ratio ratio-16x9 bg-light rounded overflow-hidden">
                                                <x-news-thumbnail :news="$mainFeature"
                                                    classes="w-100 h-100 object-fit-cover" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-5 d-flex flex-column justify-content-center">
                                        <h2 class="fw-black lh-sm h3 mb-3"><a
                                                href="{{ route('news.show', $mainFeature->slug) }}"
                                                class="text-reset text-decoration-none hover-danger">{{ $mainFeature->title }}</a>
                                        </h2>
                                        <p class="fs-6 text-muted mb-3">
                                            {{ Str::limit($mainFeature->short_description, 100) }}</p>
                                        <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i>
                                            {{ $mainFeature->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Bottom 2 News -->
                        <div class="row g-4 pt-3 border-top">
                            @foreach ($latestFeaturedNews->slice(3, 2) as $newsItem)
                                <div class="col-sm-6">
                                    <div class="row g-2">
                                        <div class="col-8">
                                            <h5 class="h6 fw-bold mb-2 lh-base"><a
                                                    href="{{ route('news.show', $newsItem->slug) }}"
                                                    class="text-reset text-decoration-none hover-danger">{{ $newsItem->title }}</a>
                                            </h5>
                                            <p class="text-muted small m-0 mb-2">
                                                {{ Str::limit($newsItem->short_description, 60) }}</p>
                                            <span class="text-muted small" style="font-size: 0.75rem;"><i
                                                    class="fa-regular fa-clock me-1"></i>
                                                {{ $newsItem->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="col-4">
                                            <div class="ratio ratio-1x1 bg-light rounded overflow-hidden">
                                                <x-news-thumbnail :news="$newsItem"
                                                    classes="w-100 h-100 object-fit-cover" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right Column: Ad -->
                    <div class="col-lg-3 ps-lg-4">
                        <div class="sticky-top" style="top: 90px;">
                            <div class="mb-4">
                                {!! renderAdSlot('sidebar_top', 'w-100 rounded overflow-hidden') !!}
                            </div>

                            @if (isset($latestFeaturedNews[5]))
                                @php $newsItem = $latestFeaturedNews[5]; @endphp
                                <div class="pt-2">
                                    <div class="row g-2 mb-2">
                                        <div class="col-7">
                                            <h4 class="h5 fw-bold mb-0 lh-base"><a
                                                    href="{{ route('news.show', $newsItem->slug) }}"
                                                    class="text-primary text-decoration-none hover-danger">{{ $newsItem->title }}</a>
                                            </h4>
                                        </div>
                                        <div class="col-5">
                                            <div class="ratio ratio-4x3 bg-light rounded overflow-hidden">
                                                <x-news-thumbnail :news="$newsItem"
                                                    classes="w-100 h-100 object-fit-cover" />
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted small m-0 mb-2">
                                        {{ Str::limit($newsItem->short_description, 100) }}</p>
                                    <span class="text-muted small" style="font-size: 0.75rem;"><i
                                            class="fa-regular fa-clock me-1"></i>
                                        {{ $newsItem->created_at->diffForHumans() }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </section>
        @endif

        <!-- QUICK NEWS HORIZONTAL GRID -->
        @if ($categorySections->count() > 0)
            <section class="mb-5" data-aos="fade-up">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="h4 fw-extrabold border-start border-4 border-danger ps-2 m-0">ঝটপট খবর</h3>
                    <a href="{{ route('news.quick') }}" class="text-danger fw-bold text-decoration-none small">সব দেখুন
                        <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="row g-3">
                    @foreach ($categorySections->take(4) as $cat)
                        @php $newsItem = $cat->news->first(); @endphp
                        @if ($newsItem)
                            <div class="col-6 col-md-3">
                                <div class="glass-card h-100 overflow-hidden d-flex flex-column">
                                    <div class="img-zoom-container position-relative ratio ratio-16x9">
                                        <x-news-thumbnail :news="$newsItem" classes="object-fit-cover" />
                                        <div class="position-absolute m-2"
                                            style="top:0; left:0; z-index: 10; width: auto; height: auto;">
                                            <span class="badge bg-danger px-2 py-1 fs-7 fw-bold"><a
                                                    href="{{ route('category', $cat->slug) }}"
                                                    class="text-white text-decoration-none">{{ $cat->name }}</a></span>
                                        </div>
                                    </div>
                                    <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                                        <h4 class="h6 fw-bold mb-2 line-clamp-2"><a
                                                href="{{ route('news.show', $newsItem->slug) }}"
                                                class="text-reset text-decoration-none hover-danger">{{ $newsItem->title }}</a>
                                        </h4>
                                        <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i>
                                            {{ $newsItem->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <!-- TRENDING & MOST READ MODULE -->
        <section id="trending-section" class="mb-5" data-aos="fade-up">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="glass-card p-4 h-100">
                        <h3 class="h4 fw-extrabold mb-4 d-flex align-items-center gap-2 text-danger">
                            <i class="fa-solid fa-fire"></i> ট্রেন্ডিং সংবাদ
                        </h3>
                        <div class="d-flex flex-column gap-3">
                            @foreach ($trending->take(3) as $index => $trend)
                                <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                    <span class="fw-black fs-2 text-danger opacity-75 font-en"
                                        style="line-height:1;">{{ sprintf('%02d', $index + 1) }}</span>
                                    <div>
                                        <h4 class="h6 fw-bold mb-1"><a href="{{ route('news.show', $trend->slug) }}"
                                                class="text-reset text-decoration-none hover-danger">{{ $trend->title }}</a>
                                        </h4>
                                        <small class="text-muted"><i class="fa-regular fa-eye me-1"></i>
                                            {{ number_format($trend->views) }} পড়া হয়েছে</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="glass-card p-4 h-100">
                        <h3 class="h4 fw-extrabold mb-4 d-flex align-items-center gap-2 text-primary">
                            <i class="fa-solid fa-chart-line"></i> সর্বাধিক পঠিত
                        </h3>
                        <div class="d-flex flex-column gap-3">
                            @foreach ($mostRead->take(3) as $index => $most)
                                <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                    <span class="fw-black fs-2 text-secondary opacity-50 font-en"
                                        style="line-height:1;">{{ sprintf('%02d', $index + 1) }}</span>
                                    <div>
                                        <h4 class="h6 fw-bold mb-1"><a href="{{ route('news.show', $most->slug) }}"
                                                class="text-reset text-decoration-none hover-danger">{{ $most->title }}</a>
                                        </h4>
                                        <small class="text-muted"><i class="fa-regular fa-clock me-1"></i>
                                            {{ $most->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TECHNOLOGY SECTION (Dark Styling) -->
        @php
            $techCatSlug = \App\Models\Setting::get('tech_category', 'technology');
            $techCat =
                \App\Models\Category::where('slug', $techCatSlug)
                    ->with([
                        'news' => function ($query) {
                            $query->published()->latest()->take(3);
                        },
                    ])
                    ->first() ?? $categorySections->first();
        @endphp
        @if ($techCat)
            <section class="p-4 p-md-5 rounded-4 mb-5 position-relative overflow-hidden"
                style="background: #0B1220; color: #FFFFFF;" data-aos="fade-up">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="h4 fw-extrabold text-white border-start border-4 border-danger ps-2 m-0">
                        {{ $techCat->name }}</h3>
                    <span class="badge bg-outline-light border text-white">TECH PULSE</span>
                </div>
                <div class="row g-4">
                    @foreach ($techCat->news->take(3) as $news)
                        <div class="col-lg-4">
                            <div class="p-3 rounded-3 h-100"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                <span class="badge bg-danger mb-2">{{ $techCat->name }}</span>
                                <h4 class="h5 fw-bold text-white"><a href="{{ route('news.show', $news->slug) }}"
                                        class="text-white text-decoration-none hover-danger">{{ $news->title }}</a></h4>
                                <p class="text-light opacity-75 small">{{ Str::limit($news->short_description, 80) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- VIDEO NEWS SECTION (Swiper Slider) -->
        @if ($videoNews->count() > 0)
            <section id="video-section" class="mb-5" data-aos="fade-up">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="h4 fw-extrabold border-start border-4 border-danger ps-2 m-0"><i
                            class="fa-solid fa-circle-play text-danger me-1"></i> ভিডিও সংবাদ</h3>
                </div>
                <div class="swiper videoSwiper pb-4">
                    <div class="swiper-wrapper">
                        @foreach ($videoNews as $video)
                            <div class="swiper-slide">
                                <div class="glass-card overflow-hidden">
                                    <div class="position-relative ratio ratio-16x9">
                                        <x-news-thumbnail :news="$video" classes="object-fit-cover" />
                                        <a href="{{ route('news.show', $video->slug) }}"
                                            class="position-absolute top-50 start-50 translate-middle text-white fs-1 opacity-90"
                                            style="width:auto; height:auto; z-index:10;">
                                            <i class="fa-solid fa-circle-play text-danger bg-white rounded-circle p-1"></i>
                                        </a>
                                    </div>
                                    <div class="p-3">
                                        <h5 class="h6 fw-bold m-0 line-clamp-2"><a
                                                href="{{ route('news.show', $video->slug) }}"
                                                class="text-reset text-decoration-none hover-danger">{{ $video->title }}</a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>
        @endif

        <!-- NEWSLETTER CTA MODULE -->
        <section class="p-4 p-md-5 rounded-4 glass-panel text-white position-relative overflow-hidden mt-5"
            style="background: linear-gradient(135deg, #0B1220 0%, #111827 100%); border: 1px solid rgba(227, 27, 35, 0.3);">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-danger mb-2">নিউজলেটার</span>
                    <h3 class="fw-extrabold display-6 text-white mb-2">প্রতিদিনের গুরুত্বপূর্ণ খবর আপনার ইনবক্সে</h3>
                    <p class="text-light opacity-75 mb-3 mb-lg-0">কোনো ভুয়া খবর নয়, সারাদিনের বাছাই করা সেরা সংবাদের
                        সারসংক্ষেপ পেতে সাবস্ক্রাইব করুন।</p>
                </div>
                <div class="col-lg-5">
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="email" name="email"
                            class="form-control form-control-lg rounded-pill border-0 px-4"
                            placeholder="আপনার ইমেইল লিখুন..." required>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold text-nowrap">সাবস্ক্রাইব
                            →</button>
                    </form>
                    <small class="text-white d-block mt-2" style="font-size: 0.75rem;">আমরা আপনার তথ্যের সুরক্ষা নিশ্চিত
                        করি। যেকোনো সময় আনসাবস্ক্রাইব করতে পারবেন।</small>
                </div>
            </div>
        </section>

    </main>
@endsection

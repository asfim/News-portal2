@extends('layouts.app')

@section('title', \App\Models\Setting::get('site_name', 'দৈনিক জনকথা') . ' | সংবাদপত্র')

@section('content')

    @if (!isset($featured) && (!isset($recent) || $recent->isEmpty()))
        <!-- ==================== STATIC FALLBACK (No DB News Available) ==================== -->
        <main class="wrap">

            <!-- Hero -->
            <section class="hero">
                <div class="hero-main">
                    <span class="glance-tag">একনজরে</span>
                    <figure>
                        <div class="art art1"></div>
                    </figure>
                    <h2>নদীভাঙন রোধে দশ জেলায় নতুন বাঁধ প্রকল্প অনুমোদন</h2>
                    <p>পরিকল্পনা কমিশনের সবুজ সংকেতের পর আগামী অর্থবছর থেকে কাজ শুরু হবে বলে জানিয়েছে পানি উন্নয়ন বোর্ড।
                        দীর্ঘমেয়াদী রক্ষণাবেক্ষণ পরিকল্পনা ছাড়া প্রকল্পের সুফল টেকসই হবে না বলছেন বিশেষজ্ঞরা।</p>

                    <div class="hero-sub-grid">
                        <div>
                            <figure class="thumb">
                                <div class="art art3"></div><span class="badge-num">২</span>
                            </figure>
                            <h4>বিদ্যুৎ বিভ্রাটে অতিষ্ঠ নগরবাসী, কারণ খুঁজছে বিতরণ সংস্থা</h4>
                        </div>
                        <div>
                            <figure class="thumb">
                                <div class="art art4"></div><span class="badge-num">৩</span>
                            </figure>
                            <h4>প্রাথমিক শিক্ষক নিয়োগে নতুন বিধিমালার খসড়া প্রকাশ</h4>
                        </div>
                    </div>
                </div>

                <aside class="side-list">
                    <h3 class="head">সর্বশেষ</h3>
                    <div class="side-item"><span class="dot">১</span>
                        <div>
                            <h5>মধ্যপ্রাচ্যে উত্তেজনায় জ্বালানি তেলের বাজারে অস্থিরতা</h5>
                            <div class="t">১২ মিনিট আগে</div>
                        </div>
                    </div>
                    <div class="side-item"><span class="dot">২</span>
                        <div>
                            <h5>রপ্তানি আয়ে টানা তৃতীয় মাসে প্রবৃদ্ধি</h5>
                            <div class="t">৩০ মিনিট আগে</div>
                        </div>
                    </div>
                    <div class="side-item"><span class="dot">৩</span>
                        <div>
                            <h5>উপকূলীয় অঞ্চলে ভারী বৃষ্টির পূর্বাভাস, সতর্কসংকেত জারি</h5>
                            <div class="t">৫০ মিনিট আগে</div>
                        </div>
                    </div>
                    <div class="side-item"><span class="dot">৪</span>
                        <div>
                            <h5>স্থানীয় হস্তশিল্পে বিদেশি ক্রেতাদের আগ্রহ বাড়ছে</h5>
                            <div class="t">১ ঘণ্টা আগে</div>
                        </div>
                    </div>
                    <div class="side-item"><span class="dot">৫</span>
                        <div>
                            <h5>প্রবাসী আয় এল রেকর্ড পরিমাণে, স্বস্তিতে অর্থনীতি</h5>
                            <div class="t">২ ঘণ্টা আগে</div>
                        </div>
                    </div>
                    <div class="side-item" style="border-bottom:none;"><span class="dot">৬</span>
                        <div>
                            <h5>যুব উদ্যোক্তাদের জন্য নতুন ঋণ প্রকল্প ঘোষণা</h5>
                            <div class="t">৩ ঘণ্টা আগে</div>
                        </div>
                    </div>
                </aside>
            </section>

            <!-- Ad band -->
            <div class="ad-band">
                <div>
                    <div class="l">জনকথা হোম লোন</div>
                    <div class="s">এখন মাত্র এক ক্লিকে আবেদন করুন</div>
                </div>
                <div class="cta">বিস্তারিত জানুন</div>
            </div>

            <!-- Video row -->
            <div class="sec-head">
                <h3>ভিডিও</h3><a class="more" href="#">সব দেখুন ›</a>
            </div>
            <div class="video-row">
                <div class="video-card">
                    <figure>
                        <div class="art art2"></div>
                        <div class="play"></div>
                    </figure>
                    <h5>মেট্রোরেলের নতুন রুট নিয়ে প্রতিবেদন</h5>
                </div>
                <div class="video-card">
                    <figure>
                        <div class="art art6"></div>
                        <div class="play"></div>
                    </figure>
                    <h5>এশিয়া কাপের প্রস্তুতি নিয়ে অনুশীলনে দল</h5>
                </div>
                <div class="video-card">
                    <figure>
                        <div class="art art9"></div>
                        <div class="play"></div>
                    </figure>
                    <h5>বর্ষায় নৌকা ভ্রমণে পর্যটকদের ভিড়</h5>
                </div>
                <div class="video-card">
                    <figure>
                        <div class="art art7"></div>
                        <div class="play"></div>
                    </figure>
                    <h5>চলচ্চিত্র উৎসবে তরুণ নির্মাতাদের কাজ</h5>
                </div>
            </div>

            <!-- বাণিজ্য -->
            <div class="sec-head">
                <h3>বাণিজ্য</h3><a class="more" href="#">সব দেখুন ›</a>
            </div>
            <div class="mix-grid">
                <div class="mix-lead">
                    <span class="cat-chip chip-red">প্রতিবেদন</span>
                    <figure>
                        <div class="art art5"></div>
                    </figure>
                    <h4>রপ্তানি আয়ে টানা তৃতীয় মাসে প্রবৃদ্ধি, এগিয়ে পোশাকখাত</h4>
                    <p>নতুন বাজার সম্প্রসারণ ও কাঁচামাল আমদানিতে শুল্ক ছাড়ের সুফল মিলছে বলছেন উদ্যোক্তারা।</p>
                </div>
                <div class="mix-col">
                    <figure>
                        <div class="art art8"></div>
                    </figure>
                    <span class="cat-chip chip-blue">বাজার</span>
                    <h5>শেয়ারবাজারে টানা তৃতীয় দিনের মতো সূচকের ঊর্ধ্বগতি</h5>
                    <figure>
                        <div class="art art4"></div>
                    </figure>
                    <h5>জ্বালানি তেলের দাম সমন্বয়ে নতুন নীতিমালা</h5>
                </div>
                <div class="mix-col">
                    <figure>
                        <div class="art art3"></div>
                    </figure>
                    <span class="cat-chip chip-purple">বিশ্লেষণ</span>
                    <h5>মুদ্রাস্ফীতি নিয়ন্ত্রণে কেন্দ্রীয় ব্যাংকের নতুন পদক্ষেপ কতটা কার্যকর</h5>
                    <figure>
                        <div class="art art9"></div>
                    </figure>
                    <h5>ক্ষুদ্র উদ্যোক্তাদের জন্য সহজ শর্তে ঋণ চালু</h5>
                </div>
            </div>

            <!-- খেলা -->
            <div class="sec-head">
                <h3>খেলা</h3><a class="more" href="#">সব দেখুন ›</a>
            </div>
            <div class="mix-grid">
                <div class="mix-lead">
                    <span class="cat-chip chip-red">ক্রিকেট</span>
                    <figure>
                        <div class="art art2"></div>
                    </figure>
                    <h4>এশিয়া কাপের আগে ঘরের মাঠে প্রস্তুতি ম্যাচ জিতল বাংলাদেশ</h4>
                    <p>ব্যাটিং অর্ডারে পরীক্ষা-নিরীক্ষা চালিয়েও স্বস্তির জয় পেল দল, দাপট দেখালেন বোলাররাও।</p>
                </div>
                <div class="mix-col">
                    <figure>
                        <div class="art art6"></div>
                    </figure>
                    <span class="cat-chip chip-blue">ফুটবল</span>
                    <h5>স্থানীয় লিগে চমক দেখাচ্ছে তৃতীয় বিভাগের নতুন ক্লাব</h5>
                    <figure>
                        <div class="art art9"></div>
                    </figure>
                    <h5>আন্তর্জাতিক মিটে রেকর্ড গড়লেন তরুণ দৌড়বিদ</h5>
                </div>
                <div class="mix-col">
                    <figure>
                        <div class="art art10"></div>
                    </figure>
                    <span class="cat-chip chip-purple">ব্যাডমিন্টন</span>
                    <h5>জাতীয় চ্যাম্পিয়নশিপে নতুন মুখের চমক</h5>
                    <figure>
                        <div class="art art5"></div>
                    </figure>
                    <h5>উপজেলা পর্যায়ে ক্রীড়া অবকাঠামো উন্নয়নে বরাদ্দ বাড়ল</h5>
                </div>
            </div>

            <!-- বিনোদন ও জীবনযাপন -->
            <div class="sec-head">
                <h3>বিনোদন ও জীবনযাপন</h3><a class="more" href="#">সব দেখুন ›</a>
            </div>
            <div class="mix-grid">
                <div class="mix-lead">
                    <span class="cat-chip chip-red">বিনোদন</span>
                    <figure>
                        <div class="art art7"></div>
                    </figure>
                    <h4>নতুন চলচ্চিত্র উৎসবে দেখানো হবে দশটি স্বল্পদৈর্ঘ্য চলচ্চিত্র</h4>
                    <p>তরুণ নির্মাতাদের কাজ নিয়ে আয়োজিত হচ্ছে সপ্তাহব্যাপী এই আয়োজন, থাকছে দর্শক ভোটের সুযোগ।</p>
                </div>
                <div class="mix-col">
                    <figure>
                        <div class="art art8"></div>
                    </figure>
                    <span class="cat-chip chip-blue">জীবনযাপন</span>
                    <h5>শহুরে ব্যস্ত জীবনে ঘুমের ঘাটতি, কী বলছেন চিকিৎসকরা</h5>
                    <figure>
                        <div class="art art1"></div>
                    </figure>
                    <h5>বর্ষায় জনপ্রিয় হয়ে উঠছে খিচুড়ির নতুন সংস্করণ</h5>
                </div>
                <div class="mix-col">
                    <figure>
                        <div class="art art4"></div>
                    </figure>
                    <span class="cat-chip chip-purple">প্রযুক্তি</span>
                    <h5>স্থানীয় স্টার্টআপের অ্যাপ পেল আঞ্চলিক পুরস্কার</h5>
                    <figure>
                        <div class="art art3"></div>
                    </figure>
                    <h5>শিক্ষার্থীদের জন্য বিনামূল্যে কোডিং কর্মশালা</h5>
                </div>
            </div>

        </main>

        <!-- Dark multimedia section -->
        <section class="dark-sec">
            <div class="wrap">
                <div class="sec-head">
                    <h3>ছবিতে বাংলাদেশ</h3><a class="more" href="#">গ্যালারি ›</a>
                </div>
                <div class="dark-grid">
                    <div class="big">
                        <figure>
                            <div class="art art2"></div>
                        </figure>
                        <h4>বর্ষার জলে ভেসে যাওয়া গ্রামীণ জনপদ</h4>
                        <p class="t">হাওর অঞ্চল থেকে পাঠানো ছবি</p>
                    </div>
                    <div>
                        <figure>
                            <div class="art art6"></div>
                        </figure>
                        <h4>ধানক্ষেতে ব্যস্ত কৃষক পরিবার</h4>
                        <p class="t">উত্তরাঞ্চল থেকে</p>
                    </div>
                    <div>
                        <figure>
                            <div class="art art10"></div>
                        </figure>
                        <h4>নদীতীরের সকাল</h4>
                        <p class="t">দক্ষিণাঞ্চল থেকে</p>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- ==================== DYNAMIC DATABASE POWERED SECTIONS ==================== -->
        <main class="wrap">

            <!-- Hero Section -->
            <section class="hero">
                <div class="hero-main">
                    @if ($latestFeaturedNews->isNotEmpty())
                        <div class="latest-layout">

                            <!-- Row 1: 1 Big Card (Image left, Title & description right) -->
                            @if ($latestFeaturedNews->count() >= 1)
                                @php
                                    $row1Post = $latestFeaturedNews->first();
                                    $caption = null;
                                    if ($row1Post->featuredImage && $row1Post->featuredImage->caption) {
                                        $caption = $row1Post->featuredImage->caption;
                                    } elseif ($row1Post->thumbnailImage && $row1Post->thumbnailImage->caption) {
                                        $caption = $row1Post->thumbnailImage->caption;
                                    } elseif ($row1Post->featuredImage && $row1Post->featuredImage->alt_text) {
                                        $caption = $row1Post->featuredImage->alt_text;
                                    } elseif ($row1Post->thumbnailImage && $row1Post->thumbnailImage->alt_text) {
                                        $caption = $row1Post->thumbnailImage->alt_text;
                                    }
                                @endphp
                                <div class="latest-row-1">
                                    <div class="latest-lead-card">
                                        <div class="lead-img-container">
                                            <div class="lead-img">
                                                <a href="{{ route('news.show', $row1Post->slug) }}">
                                                    @if ($row1Post->thumbnailImage || $row1Post->featuredImage)
                                                        <x-news-thumbnail :news="$row1Post"
                                                            classes="w-100 h-100 object-fit-cover" />
                                                    @else
                                                        <div class="art art1 w-100 h-100"></div>
                                                    @endif
                                                    @if ($row1Post->video_url)
                                                        <div class="play-indicator"></div>
                                                    @endif
                                                </a>
                                            </div>
                                            @if ($caption)
                                                <div class="image-caption">{{ $caption }}</div>
                                            @endif
                                        </div>
                                        <div class="lead-content">
                                            <h2><a
                                                    href="{{ route('news.show', $row1Post->slug) }}">{{ $row1Post->title }}</a>
                                            </h2>
                                            <p>{{ Str::limit($row1Post->short_description, 180) }}</p>
                                            <span class="time">{{ $row1Post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Row 2: 2 Columns (Title left, Image right) -->
                            @if ($latestFeaturedNews->count() >= 2)
                                @php $row2Posts = $latestFeaturedNews->slice(1, 2); @endphp
                                <div class="latest-row-2">
                                    @foreach ($row2Posts as $item)
                                        <div class="latest-card-style-2">
                                            <div class="card-content">
                                                <h4><a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                                </h4>
                                                <p>{{ Str::limit($item->short_description, 120) }}</p>
                                                <span class="time">{{ $item->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="card-img">
                                                <a href="{{ route('news.show', $item->slug) }}">
                                                    @if ($item->thumbnailImage || $item->featuredImage)
                                                        <x-news-thumbnail :news="$item"
                                                            classes="w-100 h-100 object-fit-cover" />
                                                    @else
                                                        <div class="art art{{ $loop->iteration + 1 }} w-100 h-100"></div>
                                                    @endif
                                                    @if ($item->video_url)
                                                        <div class="play-indicator"></div>
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Row 3: 3 Columns (Image top, Title below) -->
                            @if ($latestFeaturedNews->count() >= 4)
                                @php $row3Posts = $latestFeaturedNews->slice(3, 3); @endphp
                                <div class="latest-row-3">
                                    @foreach ($row3Posts as $item)
                                        <div class="latest-card-style-3">
                                            <div class="card-img">
                                                <a href="{{ route('news.show', $item->slug) }}">
                                                    @if ($item->thumbnailImage || $item->featuredImage)
                                                        <x-news-thumbnail :news="$item"
                                                            classes="w-100 h-100 object-fit-cover" />
                                                    @else
                                                        <div class="art art{{ $loop->iteration + 3 }} w-100 h-100"></div>
                                                    @endif
                                                    @if ($item->video_url)
                                                        <div class="play-indicator"></div>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="card-content">
                                                <h4><a
                                                        href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                                </h4>
                                                <span class="time">{{ $item->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Row 4: 3 Columns (Text only) -->
                            @if ($latestFeaturedNews->count() >= 7)
                                @php $row4Posts = $latestFeaturedNews->slice(6, 3); @endphp
                                <div class="latest-row-4">
                                    @foreach ($row4Posts as $item)
                                        <div class="latest-card-style-4">
                                            <h4><a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                            </h4>
                                            <p>{{ Str::limit($item->short_description, 140) }}</p>
                                            <span class="time">{{ $item->created_at->diffForHumans() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    @else
                        <div class="text-center py-5 text-secondary">কোনো সর্বশেষ খবর পাওয়া যায়নি।</div>
                    @endif
                </div>

                <!-- Side list: Breaking News -->
                <aside class="side-list">
                    <h3 class="head">ব্রেকিং নিউজ</h3>
                    @php
                        $sidebarNews = $breaking->isNotEmpty() ? $breaking : $recent;
                    @endphp
                    @foreach ($sidebarNews->take(12) as $index => $item)
                        <div class="side-item" {!! $loop->last ? 'style="border-bottom:none;"' : '' !!}>
                            <span class="dot">{{ toBengaliNumber($loop->iteration) }}</span>
                            <div>
                                <h5><a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a></h5>
                                <div class="t">{{ $item->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </aside>
            </section>




            <!-- Ad band (Dynamic or Custom placeholder fallback) -->
            @if (function_exists('renderAdSlot') && !empty(renderAdSlot('homepage_banner')))
                <div class="ad-band-custom" style="margin-top: 26px;">
                    {!! renderAdSlot('homepage_banner') !!}
                </div>
            @else
                <div class="ad-band">
                    <div>
                        <div class="l">{{ \App\Models\Setting::get('site_name', 'জনকথা') }} হোম লোন</div>
                        <div class="s">এখন মাত্র এক ক্লিকে আবেদন করুন</div>
                    </div>
                    <div class="cta" style="cursor:pointer;">বিস্তারিত জানুন</div>
                </div>
            @endif

            <!-- Video row -->
            @if ($videoNews->count() > 0)
                <div class="sec-head">
                    <h3>ভিডিও</h3><a class="more" href="{{ route('news.latest') }}">সব দেখুন ›</a>
                </div>
                <div class="video-row">
                    @foreach ($videoNews->take(4) as $video)
                        <div class="video-card">
                            <a href="{{ route('news.show', $video->slug) }}">
                                <figure>
                                    @if ($video->thumbnailImage || $video->featuredImage)
                                        <x-news-thumbnail :news="$video" classes="w-100 h-100 object-fit-cover" />
                                    @else
                                        <div class="art art{{ (($loop->iteration * 2) % 10) + 1 }}"></div>
                                    @endif
                                    <div class="play"></div>
                                </figure>
                                <h5>{{ $video->title }}</h5>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Dynamic Category Sections -->
            @foreach ($categorySections as $sectionIndex => $section)
                @php
                    $posts = $section->news;
                    if ($posts->isEmpty()) {
                        continue;
                    }
                @endphp

                @if ($section->slug === 'sports')
                    <!-- Special Sports Section Layout -->
                    <div class="sec-head">
                        <h3 class="sports-title"><span class="blue-dot"></span>{{ $section->name }}</h3>
                        <a class="more" href="{{ route('category', $section->slug) }}">সব দেখুন ›</a>
                    </div>

                    <div class="sports-layout">
                        @php
                            $heroPost = $posts->first();

                            // Get ALL trending posts for this category (category_id = $section->id AND trending_news = 1)
                            $sidebarPosts = \App\Models\News::published()
                                ->where('category_id', $section->id)
                                ->where('trending_news', 1)
                                ->latest()
                                ->take(9)
                                ->get();

                            // Get bottom grid posts (excluding hero and sidebar posts so no duplicate cards)
                            $usedIds = collect([$heroPost ? $heroPost->id : null])
                                ->merge($sidebarPosts->pluck('id'))
                                ->filter();
                            $bottomLimit = $posts->count() >= 6 ? 3 : 2;
                            $mainBottomPosts = $posts
                                ->reject(function ($p) use ($usedIds) {
                                    return $usedIds->contains($p->id);
                                })
                                ->take($bottomLimit);

                            // Fallback if not enough non-duplicate posts available
                            if ($mainBottomPosts->isEmpty() && $posts->count() > 1) {
                                $mainBottomPosts = $posts->slice(1, $bottomLimit);
                            }
                        @endphp

                        <!-- Main Content (Left) -->
                        <div class="sports-main">
                            @if ($heroPost)
                                <div class="sports-hero-card">
                                    <a href="{{ route('news.show', $heroPost->slug) }}">
                                        <figure class="sports-hero-img">
                                            @if ($heroPost->thumbnailImage || $heroPost->featuredImage)
                                                <x-news-thumbnail :news="$heroPost"
                                                    classes="w-100 h-100 object-fit-cover" />
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
                                                        <x-news-thumbnail :news="$post"
                                                            classes="w-100 h-100 object-fit-cover" />
                                                    @else
                                                        <div class="art art{{ $loop->iteration + 1 }} w-100 h-100"></div>
                                                    @endif
                                                    @if ($post->video_url)
                                                        <div class="play-indicator"></div>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="card-content">
                                                <h5><a
                                                        href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a>
                                                </h5>
                                                <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Sidebar Content (Right) -->
                        <div class="sports-sidebar">
                            <!-- Ad Slot / Mock Ad -->
                            <div class="sports-ad">
                                @if (function_exists('renderAdSlot') && !empty(renderAdSlot('sports_sidebar')))
                                    {!! renderAdSlot('sports_sidebar') !!}
                                @else
                                    <div class="mock-sports-ad">
                                        <div class="ad-tag">ADVERTISEMENT</div>
                                        <div class="ad-content-box">
                                            <span class="fw-bold d-block mb-1 text-success">Resort Booking open!</span>
                                            <span class="small text-secondary">Enjoy Evergreen Eco Resort</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if ($sidebarPosts->count() > 0)
                                <div class="sports-side-list">
                                    @foreach ($sidebarPosts as $post)
                                        <div class="sports-side-card">
                                            <div class="card-content">
                                                <h6><a
                                                        href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a>
                                                </h6>
                                                <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="card-img">
                                                <a href="{{ route('news.show', $post->slug) }}">
                                                    @if ($post->thumbnailImage || $post->featuredImage)
                                                        <x-news-thumbnail :news="$post"
                                                            classes="w-100 h-100 object-fit-cover" />
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
                @else
                    <!-- Standard Category Layout (2-row structure) -->
                    <div class="sec-head">
                        <h3>{{ $section->name }}</h3>
                        <a class="more" href="{{ route('category', $section->slug) }}">সব দেখুন ›</a>
                    </div>

                    <div class="category-section-layout">

                        <!-- Row 1: 2 Columns (Title & description left, Image right) -->
                        @php
                            $row1Posts = $posts->take(2);
                            $row2Posts = $posts->slice(2, 3);
                        @endphp
                        @if ($row1Posts->count() > 0)
                            <div class="cat-row-1">
                                @foreach ($row1Posts as $post)
                                    <div class="cat-card-style-1">
                                        <div class="card-content">
                                            <h4><a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a>
                                            </h4>
                                            <p>{{ Str::limit($post->short_description, 120) }}</p>
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
                                            <h4><a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a>
                                            </h4>
                                            <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Row 3: 3 Columns (Text-only news) -->
                        @php
                            $row3Posts = $posts->slice(5, 3);
                        @endphp
                        @if ($row3Posts->count() > 0)
                            <div class="cat-row-3">
                                @foreach ($row3Posts as $post)
                                    <div class="cat-card-style-3">
                                        <h4><a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a></h4>
                                        <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                @endif
            @endforeach

        </main>

        <!-- Dark multimedia section (Dynamic from latest image articles) -->
        @php
            $galleryNews = \App\Models\News::published()
                ->whereNotNull('featured_image')
                ->orWhereHas('featuredImage')
                ->latest()
                ->take(3)
                ->get();
            if ($galleryNews->count() < 3) {
                $galleryNews = $recent->take(3);
            }
            $bigGallery = $galleryNews->first();
            $subGallery = $galleryNews->slice(1, 2);
        @endphp

        @if ($galleryNews->count() > 0)
            <section class="dark-sec">
                <div class="wrap">
                    <div class="sec-head">
                        <h3>ছবিতে বাংলাদেশ</h3><a class="more" href="{{ route('news.latest') }}">গ্যালারি ›</a>
                    </div>
                    <div class="dark-grid">
                        @if ($bigGallery)
                            <div class="big">
                                <a href="{{ route('news.show', $bigGallery->slug) }}">
                                    <figure>
                                        @if ($bigGallery->thumbnailImage || $bigGallery->featuredImage)
                                            <x-news-thumbnail :news="$bigGallery" classes="w-100 h-100 object-fit-cover" />
                                        @else
                                            <div class="art art2"></div>
                                        @endif
                                    </figure>
                                    <h4>{{ $bigGallery->title }}</h4>
                                </a>
                                <p class="t">{{ $bigGallery->category ? $bigGallery->category->name : 'বাংলাদেশ' }}
                                </p>
                            </div>
                        @endif

                        @foreach ($subGallery as $index => $item)
                            <div>
                                <a href="{{ route('news.show', $item->slug) }}">
                                    <figure>
                                        @if ($item->thumbnailImage || $item->featuredImage)
                                            <x-news-thumbnail :news="$item" classes="w-100 h-100 object-fit-cover" />
                                        @else
                                            <div class="art art{{ $index == 0 ? 6 : 10 }}"></div>
                                        @endif
                                    </figure>
                                    <h4>{{ $item->title }}</h4>
                                </a>
                                <p class="t">{{ $item->category ? $item->category->name : 'বাংলাদেশ' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    @endif

@endsection

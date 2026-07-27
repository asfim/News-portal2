<!DOCTYPE html>
<html lang="bn" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="NewsHub Pro - খবরের সাথে, সবসময়। সর্বশেষ বাংলা সংবাদ, রাজনীতি, অর্থনীতি, খেলা ও বিনোদন।">
    
    <!-- Favicon -->
    @if($favicon = \App\Models\Setting::get('favicon'))
        <link rel="shortcut icon" href="{{ asset($favicon) }}" type="image/x-icon">
    @else
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif

    <title>@yield('title', 'NewsHub Pro | খবরের সাথে, সবসময়')</title>

    <!-- Google Fonts (Bengali & English) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Third-Party CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Premium Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>

    <!-- 1. TOP INFORMATION BAR & HEADER -->
    @include('frontend.partials.header')

    <!-- 2. MAIN NAVIGATION BAR -->
    @include('frontend.partials.navbar')

    <!-- Floating Alerts/Toasts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-4 shadow-lg" role="alert" style="z-index: 9999; border-left: 5px solid #198754;">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-4 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-4 shadow-lg" role="alert" style="z-index: 9999; border-left: 5px solid #dc3545;">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-triangle-exclamation fs-4 me-2 text-danger"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 3. BREAKING NEWS TICKER -->
    @include('frontend.partials.breaking-news')

    <!-- MAIN PAGE CONTENT -->
    @yield('content')

    <!-- 4. FOOTER SECTION -->
    @include('frontend.partials.footer')

    <!-- MOBILE BOTTOM APP NAVIGATION BAR -->
    <div class="mobile-bottom-nav">
        <a href="{{ route('home') }}" class="text-center text-decoration-none text-danger">
            <i class="fa-solid fa-house fs-5 d-block"></i>
            <span style="font-size: 0.7rem;">হোম</span>
        </a>
        <a href="{{ url('/') }}/#trending-section" class="text-center text-decoration-none text-muted">
            <i class="fa-solid fa-fire fs-5 d-block"></i>
            <span style="font-size: 0.7rem;">ট্রেন্ডিং</span>
        </a>
        <a href="{{ url('/') }}/#video-section" class="text-center text-decoration-none text-muted">
            <i class="fa-solid fa-circle-play fs-5 d-block"></i>
            <span style="font-size: 0.7rem;">ভিডিও</span>
        </a>
        <a href="javascript:void(0)" class="text-center text-decoration-none text-muted" onclick="openSearch()">
            <i class="fa-solid fa-magnifying-glass fs-5 d-block"></i>
            <span style="font-size: 0.7rem;">সার্চ</span>
        </a>
    </div>

    <!-- FULLSCREEN SEARCH OVERLAY -->
    <div id="searchOverlay" class="search-overlay align-items-center justify-content-center">
        <button onclick="closeSearch()" class="btn btn-link text-white position-absolute top-0 end-0 m-4 fs-2 text-decoration-none">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <div class="container text-center" style="max-width: 720px;">
            <h2 class="text-white fw-bold mb-4">আপনি কী খুঁজছেন?</h2>
            <form action="{{ route('search') }}" method="GET">
                <div class="input-group input-group-lg shadow-lg rounded-pill overflow-hidden bg-white p-1">
                    <input type="text" name="q" id="searchInput" class="form-control border-0 px-4 fs-4 focus-ring-0" placeholder="খবরের কীওয়ার্ড লিখুন..." required>
                    <button class="btn btn-danger rounded-pill px-4" type="submit">
                        <i class="fa-solid fa-magnifying-glass fs-4"></i>
                    </button>
                </div>
            </form>

            <div class="mt-4 text-start">
                <span class="text-muted small me-2">জনপ্রিয় অনুসন্ধান:</span>
                <div class="d-inline-flex flex-wrap gap-2 mt-2">
                    <a href="{{ route('search', ['q' => 'বাংলাদেশ']) }}" class="badge bg-secondary text-white text-decoration-none px-3 py-2 rounded-pill"># বাংলাদেশ</a>
                    <a href="{{ route('search', ['q' => 'এআই প্রযুক্তি']) }}" class="badge bg-secondary text-white text-decoration-none px-3 py-2 rounded-pill"># এআই প্রযুক্তি</a>
                    <a href="{{ route('search', ['q' => 'ক্রিকেট বিশ্বকাপ']) }}" class="badge bg-secondary text-white text-decoration-none px-3 py-2 rounded-pill"># ক্রিকেট বিশ্বকাপ</a>
                    <a href="{{ route('search', ['q' => 'শেয়ারবাজার']) }}" class="badge bg-secondary text-white text-decoration-none px-3 py-2 rounded-pill"># শেয়ারবাজার</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom Frontend JS -->
    <script src="{{ asset('js/frontend.js') }}"></script>
    @stack('scripts')
</body>
</html>

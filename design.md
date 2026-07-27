<!DOCTYPE html>
<html lang="bn" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="NewsHub Pro - খবরের সাথে, সবসময়। সর্বশেষ বাংলা সংবাদ, রাজনীতি, অর্থনীতি, খেলা ও বিনোদন।">
    <title>NewsHub Pro | খবরের সাথে, সবসময়</title>

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
    <style>
        :root {
            --nh-primary: #0B1220;
            --nh-accent: #E31B23;
            --nh-bg: #F5F7FA;
            --nh-surface: #FFFFFF;
            --nh-text: #111827;
            --nh-muted: #6B7280;
            --nh-border: #E5E7EB;
            --nh-glass: rgba(255, 255, 255, 0.85);
            --nh-glass-border: rgba(255, 255, 255, 0.4);
            --nh-shadow: 0 20px 40px -15px rgba(11, 18, 32, 0.08);
            --font-bengali: 'Noto Sans Bengali', 'Hind Siliguri', sans-serif;
            --font-english: 'Inter', sans-serif;
        }

        [data-bs-theme="dark"] {
            --nh-primary: #070B12;
            --nh-accent: #E31B23;
            --nh-bg: #070B12;
            --nh-surface: #111827;
            --nh-text: #FFFFFF;
            --nh-muted: #9CA3AF;
            --nh-border: #1F2937;
            --nh-glass: rgba(17, 24, 39, 0.85);
            --nh-glass-border: rgba(255, 255, 255, 0.08);
            --nh-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        }

        body {
            font-family: var(--font-bengali);
            background-color: var(--nh-bg);
            color: var(--nh-text);
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .font-en { font-family: var(--font-english); }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--nh-bg); }
        ::-webkit-scrollbar-thumb { background: var(--nh-muted); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--nh-accent); }

        /* Glassmorphism Classes */
        .glass-panel {
            background: var(--nh-glass);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--nh-glass-border);
            box-shadow: var(--nh-shadow);
        }

        .glass-card {
            background: var(--nh-surface);
            border: 1px solid var(--nh-border);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(0,0,0,0.12);
            border-color: var(--nh-accent);
        }

        /* Sticky Glass Navigation */
        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: var(--nh-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--nh-border);
        }

        .nav-link-custom {
            color: var(--nh-text);
            font-weight: 600;
            font-size: 1.05rem;
            padding: 0.75rem 0.9rem;
            position: relative;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            color: var(--nh-accent);
        }
        .nav-link-custom.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0.9rem;
            right: 0.9rem;
            height: 3px;
            background: var(--nh-accent);
            border-radius: 3px 3px 0 0;
        }

        /* Pulsing Live Badge Dot */
        .live-pulse {
            width: 10px;
            height: 10px;
            background-color: var(--nh-accent);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(227, 27, 35, 0.7);
            animation: pulse 1.6s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(227, 27, 35, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(227, 27, 35, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(227, 27, 35, 0); }
        }

        /* Continuous Breaking Ticker Animation */
        .ticker-wrap {
            overflow: hidden;
            white-space: nowrap;
        }
        .ticker-move {
            display: inline-block;
            animation: ticker 35s linear infinite;
        }
        .ticker-wrap:hover .ticker-move { animation-play-state: paused; }
        @keyframes ticker {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }

        /* Hover Image Zoom */
        .img-zoom-container {
            overflow: hidden;
            border-radius: inherit;
        }
        .img-zoom-container img {
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card:hover .img-zoom-container img,
        .hero-banner:hover img {
            transform: scale(1.05);
        }

        /* Search Overlay Style */
        .search-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(7, 11, 18, 0.96);
            backdrop-filter: blur(20px);
            z-index: 2000;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .search-overlay.active {
            display: flex;
            opacity: 1;
        }

        /* Responsive Mobile Bottom App Bar */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--nh-surface);
            border-top: 1px solid var(--nh-border);
            z-index: 1040;
            padding: 8px 0;
        }
        @media (max-width: 991.98px) {
            .mobile-bottom-nav { display: flex; justify-content: space-around; }
            body { padding-bottom: 60px; }
        }

        /* Utility Helper Classes */
        .hover-danger:hover { color: var(--nh-accent) !important; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body>

    <!-- 1. TOP INFORMATION BAR -->
    <div class="topbar py-1 border-bottom d-none d-md-block" style="background: var(--nh-primary); color: #9CA3AF; font-size: 0.85rem;">
        <div class="container-fluid px-lg-5">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <span class="fw-bold text-white me-2">NEWSHUB PRO</span>
                    <span class="border-end border-secondary me-2 pe-2"></span>
                    <span><i class="fa-regular fa-clock me-1"></i> রবিবার, ২৬ জুলাই ২০২৬</span>
                </div>
                <div class="col-md-4 text-center">
                    <span class="badge bg-danger me-1"><i class="fa-solid fa-location-dot"></i> ঢাকা</span>
                    <span class="text-white fw-semibold">☀ ৩১° সে.</span>
                    <span class="text-muted ms-2">আংশিক মেঘলা</span>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-inline-flex align-items-center gap-3">
                        <a href="#" class="text-reset hover-danger"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="text-reset hover-danger"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="text-reset hover-danger"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="text-reset hover-danger"><i class="fa-brands fa-x-twitter"></i></a>
                        <span class="border-end border-secondary h-100"></span>
                        <button id="themeToggle" class="btn btn-sm btn-link text-reset p-0 border-0" aria-label="Toggle Theme">
                            <i class="fa-solid fa-moon"></i>
                        </button>
                        <a href="#" class="text-white text-decoration-none fw-semibold ms-2">
                            <i class="fa-regular fa-user me-1"></i> লগইন
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. MAIN HEADER SECTION -->
    <header class="py-3 border-bottom" style="background: var(--nh-surface);">
        <div class="container-fluid px-lg-5">
            <div class="row align-items-center">
                <div class="col-6 col-md-4">
                    <a href="#" class="text-decoration-none d-flex align-items-center gap-2">
                        <div class="bg-danger text-white fw-black px-3 py-1 rounded-3 fs-3 font-en" style="letter-spacing: -1px;">
                            NH<span class="text-dark">P</span>
                        </div>
                        <div>
                            <h1 class="h3 fw-extrabold m-0 text-uppercase font-en" style="color: var(--nh-text); line-height: 1;">
                                NEWSHUB<span class="text-danger">PRO</span>
                            </h1>
                            <small class="text-muted d-block" style="font-size: 0.72rem; letter-spacing: 0.5px;">খবরের সাথে, সবসময়</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 d-none d-md-block text-center">
                    <div class="p-2 rounded-3 text-center border border-dashed" style="background: var(--nh-bg); font-size: 0.8rem;">
                        <span class="badge bg-secondary mb-1">বিজ্ঞাপন</span>
                        <p class="m-0 text-muted fw-semibold">ডিজিটাল বাংলাদেশ মেলা ২০২৬ — স্টল বুকিং চলছে!</p>
                    </div>
                </div>
                <div class="col-6 col-md-4 text-end">
                    <div class="d-flex align-items-center justify-content-end gap-2 gap-md-3">
                        <button onclick="openSearch()" class="btn btn-outline-secondary rounded-circle" style="width:42px; height:42px;" aria-label="Search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <a href="#" class="btn btn-danger rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2 fw-bold shadow-sm">
                            <span class="live-pulse bg-white"></span>
                            <span style="font-size: 0.9rem;">LIVE TV</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. MAIN NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg sticky-nav py-0">
        <div class="container-fluid px-lg-5">
            <button class="navbar-toggler my-2 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars-staggered fs-3"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-bold">
                    <li class="nav-item"><a class="nav-link-custom active" href="#"><i class="fa-solid fa-house me-1"></i> হোম</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">বাংলাদেশ</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">রাজনীতি</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">আন্তর্জাতিক</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">অর্থনীতি</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">খেলা</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">প্রযুক্তি</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">বিনোদন</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">স্বাস্থ্য</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">লাইফস্টাইল</a></li>
                    <li class="nav-item"><a class="nav-link-custom text-danger" href="#"><i class="fa-solid fa-circle-play me-1"></i> ভিডিও</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#">ফটো</a></li>
                </ul>

                <div class="d-none d-lg-block">
                    <div class="dropdown">
                        <button class="btn btn-link text-reset text-decoration-none fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            আরও
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-2">
                            <li><a class="dropdown-item rounded-2 py-2" href="#"><i class="fa-solid fa-leaf me-2 text-success"></i> পরিবেশ</a></li>
                            <li><a class="dropdown-item rounded-2 py-2" href="#"><i class="fa-solid fa-graduation-cap me-2 text-info"></i> শিক্ষা</a></li>
                            <li><a class="dropdown-item rounded-2 py-2" href="#"><i class="fa-solid fa-comments me-2 text-warning"></i> মতামত</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item rounded-2 py-2 fw-bold text-danger" href="#"><i class="fa-solid fa-bolt me-2"></i> ই-পেপার</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- 4. BREAKING NEWS TICKER -->
    <div class="breaking-news-bar py-2" style="background: rgba(227, 27, 35, 0.05); border-bottom: 1px solid rgba(227, 27, 35, 0.15);">
        <div class="container-fluid px-lg-5">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center bg-danger text-white px-3 py-1 rounded-pill me-3 shadow-sm flex-shrink-0" style="font-size: 0.85rem; font-weight: 700;">
                    <span class="live-pulse bg-white me-2"></span>
                    <span>জরুরি সংবাদ</span>
                </div>
                <div class="ticker-wrap flex-grow-1">
                    <div class="ticker-move text-dark fw-semibold" style="font-size: 0.95rem;">
                        <span class="me-5"><i class="fa-solid fa-angle-right text-danger me-1"></i> ঢাকা-চট্টগ্রাম মহাসড়কে নতুন আইটি করিডোর উদ্বোধনের ঘোষণা দিল সরকার।</span>
                        <span class="me-5"><i class="fa-solid fa-angle-right text-danger me-1"></i> টি-টোয়েন্টি বিশ্বকাপে বাংলাদেশকে বড় জয়ে অভিনন্দন জানালেন প্রধানমন্ত্রী।</span>
                        <span class="me-5"><i class="fa-solid fa-angle-right text-danger me-1"></i> কেন্দ্রীয় ব্যাংক নীতিগত সুদের হার পুনর্নির্ধারণ করেছে — নতুন সার্কুলার জারি।</span>
                        <span class="me-5"><i class="fa-solid fa-angle-right text-danger me-1"></i> কৃত্রিম বুদ্ধিমত্তা ব্যবহারে নতুন নীতিমালা প্রণয়ন করছে তথ্য প্রযুক্তি বিভাগ।</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN PAGE CONTENT -->
    <main class="container-fluid px-lg-5 py-4">

        <!-- HERO SECTION (Split Screen) -->
        <section class="row g-4 mb-5" data-aos="fade-up">
            <div class="col-lg-8">
                <div class="hero-banner position-relative overflow-hidden rounded-4 shadow-lg h-100" style="min-height: 520px;">
                    <div class="img-zoom-container w-100 h-100 position-absolute top-0 start-0">
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=1200&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Hero Featured News">
                    </div>
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(7,11,18,0) 20%, rgba(7,11,18,0.95) 100%);"></div>

                    <!-- Floating Glass Card Overlay -->
                    <div class="position-absolute bottom-0 start-0 end-0 p-3 p-md-4 m-3 m-md-4 rounded-4 glass-panel border-0 text-white" style="background: rgba(11, 18, 32, 0.75);">
                        <span class="badge bg-danger text-uppercase px-3 py-2 rounded-pill fw-bold mb-2">বাংলাদেশ</span>
                        <h2 class="fw-extrabold display-6 mb-2 text-white lh-sm" style="font-size: calc(1.3rem + 1.2vw);">
                            <a href="#article" class="text-white text-decoration-none hover-danger">স্মার্ট বাংলাদেশের ভবিষ্যৎ: কৃত্রিম বুদ্ধিমত্তা ও নতুন অর্থনৈতিক করিডোরের মহা পরিকল্পনা</a>
                        </h2>
                        <p class="text-light opacity-75 d-none d-md-block mb-3 fs-6 line-clamp-2">দেশের তথ্যপ্রযুক্তি খাতকে গতিশীল করতে সরকার গ্রহণ করেছে নানামুখী নতুন প্রকল্প। তরুণ উদ্যোক্তাদের জন্য থাকছে বিশেষ তহবিল ও হাই-টেক পার্ক সুবিধা।</p>
                        <div class="d-flex align-items-center text-muted small gap-3 opacity-90 border-top border-secondary pt-2">
                            <span><i class="fa-solid fa-user-pen text-danger me-1"></i> ফারহান আহমেদ</span>
                            <span><i class="fa-regular fa-clock me-1"></i> ১০ মিনিট আগে</span>
                            <span><i class="fa-regular fa-eye me-1"></i> ২৫,৪০০ পঠিত</span>
                        </div>
                    </div>
                </div>
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

                    <div class="timeline-container position-relative ps-3" style="border-left: 2px dashed var(--nh-border);">
                        <div class="timeline-item mb-4 position-relative">
                            <span class="position-absolute top-0 start-0 translate-middle p-1 bg-danger border border-light rounded-circle" style="left: -13px !important;"></span>
                            <small class="badge bg-secondary text-white mb-1 font-en">১০:৪৫ PM</small>
                            <h4 class="h6 fw-bold mb-1">ডিজিটাল অর্থনীতিতে বাংলাদেশের নতুন মাইলফলক স্পর্শ।</h4>
                            <p class="text-muted small m-0">আইটি খাত থেকে রপ্তানি আয় ৩৫% বৃদ্ধি পাওয়ার তথ্য প্রকাশ করা হলো।</p>
                        </div>
                        <div class="timeline-item mb-4 position-relative">
                            <span class="position-absolute top-0 start-0 translate-middle p-1 bg-secondary border border-light rounded-circle" style="left: -13px !important;"></span>
                            <small class="badge bg-secondary text-white mb-1 font-en">১০:৩০ PM</small>
                            <h4 class="h6 fw-bold mb-1">শেয়ারবাজারে সূচকের বড় উত্থান, লেনদেন পার ৬০০ কোটি।</h4>
                        </div>
                        <div class="timeline-item mb-4 position-relative">
                            <span class="position-absolute top-0 start-0 translate-middle p-1 bg-secondary border border-light rounded-circle" style="left: -13px !important;"></span>
                            <small class="badge bg-secondary text-white mb-1 font-en">১০:১৫ PM</small>
                            <h4 class="h6 fw-bold mb-1">বিশ্বকাপ প্রস্তুতিতে সেরা স্কোয়াড বেছে নেয়ার লক্ষ্য বিসিবির।</h4>
                        </div>
                        <div class="timeline-item position-relative">
                            <span class="position-absolute top-0 start-0 translate-middle p-1 bg-secondary border border-light rounded-circle" style="left: -13px !important;"></span>
                            <small class="badge bg-secondary text-white mb-1 font-en">০৯:৫৫ PM</small>
                            <h4 class="h6 fw-bold mb-1">রাজধানীতে বায়ুমানের প্রশংসনীয় উন্নতি লক্ষ্য করা গেছে।</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- QUICK NEWS HORIZONTAL GRID -->
        <section class="mb-5" data-aos="fade-up">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="h4 fw-extrabold border-start border-4 border-danger ps-2 m-0">ঝটপট খবর</h3>
                <a href="#" class="text-danger fw-bold text-decoration-none small">সব দেখুন <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="glass-card h-100 overflow-hidden d-flex flex-column">
                        <div class="img-zoom-container position-relative" style="height: 160px;">
                            <img src="https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?q=80&w=400&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Quick News 1">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fs-7 fw-bold">অর্থনীতি</span>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <h4 class="h6 fw-bold mb-2 line-clamp-2"><a href="#" class="text-reset text-decoration-none hover-danger">রপ্তানি আয়ে নতুন রেকর্ড, ডলার সংকট কমার সম্ভাবনা</a></h4>
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> ১৫ মিনিট আগে</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="glass-card h-100 overflow-hidden d-flex flex-column">
                        <div class="img-zoom-container position-relative" style="height: 160px;">
                            <img src="https://images.unsplash.com/photo-1531415074968-036ba1b575da?q=80&w=400&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Quick News 2">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fs-7 fw-bold">খেলা</span>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <h4 class="h6 fw-bold mb-2 line-clamp-2"><a href="#" class="text-reset text-decoration-none hover-danger">মিরপুরে সিরিজের প্রথম টি-২০ ম্যাচে মুখোমুখি বাংলাদেশ-শ্রীলঙ্কা</a></h4>
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> ৩০ মিনিট আগে</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="glass-card h-100 overflow-hidden d-flex flex-column">
                        <div class="img-zoom-container position-relative" style="height: 160px;">
                            <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=400&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Quick News 3">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fs-7 fw-bold">প্রযুক্তি</span>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <h4 class="h6 fw-bold mb-2 line-clamp-2"><a href="#" class="text-reset text-decoration-none hover-danger">স্যামসাং উন্মোচন করল তাদের নতুন ফোল্ডেবল স্মার্টফোন</a></h4>
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> ৪৫ মিনিট আগে</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="glass-card h-100 overflow-hidden d-flex flex-column">
                        <div class="img-zoom-container position-relative" style="height: 160px;">
                            <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=400&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Quick News 4">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fs-7 fw-bold">বিনোদন</span>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <h4 class="h6 fw-bold mb-2 line-clamp-2"><a href="#" class="text-reset text-decoration-none hover-danger">কান চলচ্চিত্র উৎসবে প্রশংসিত বাংলা শর্টফিল্ম</a></h4>
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> ১ ঘণ্টা আগে</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TRENDING & MOST READ MODULE -->
        <section class="mb-5" data-aos="fade-up">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="glass-card p-4 h-100">
                        <h3 class="h4 fw-extrabold mb-4 d-flex align-items-center gap-2 text-danger">
                            <i class="fa-solid fa-fire"></i> ট্রেন্ডিং সংবাদ
                        </h3>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                <span class="fw-black fs-2 text-danger opacity-75 font-en" style="line-height:1;">01</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1"><a href="#" class="text-reset text-decoration-none hover-danger">আইটি ফ্রিল্যান্সারদের জন্য নতুন ক্যাশ ইনসেন্টিভ ঘোষণা</a></h4>
                                    <small class="text-muted"><i class="fa-regular fa-eye me-1"></i> ১২.৫কে পড়া হয়েছে</small>
                                </div>
                            </div>
                            <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                <span class="fw-black fs-2 text-danger opacity-75 font-en" style="line-height:1;">02</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1"><a href="#" class="text-reset text-decoration-none hover-danger">বঙ্গোপসাগরে সৃষ্টি হওয়া লঘুচাপটি নিম্নচাপে পরিণত হতে পারে</a></h4>
                                    <small class="text-muted"><i class="fa-regular fa-eye me-1"></i> ৯.৮কে পড়া হয়েছে</small>
                                </div>
                            </div>
                            <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                <span class="fw-black fs-2 text-danger opacity-75 font-en" style="line-height:1;">03</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1"><a href="#" class="text-reset text-decoration-none hover-danger">মেট্রোরেলের সময়সূচিতে পরিবর্তন, রাতে চলবে অতিরিক্ত ট্রেন</a></h4>
                                    <small class="text-muted"><i class="fa-regular fa-eye me-1"></i> ৮.১কে পড়া হয়েছে</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="glass-card p-4 h-100">
                        <h3 class="h4 fw-extrabold mb-4 d-flex align-items-center gap-2 text-primary">
                            <i class="fa-solid fa-chart-line"></i> সর্বাধিক পঠিত
                        </h3>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                <span class="fw-black fs-2 text-secondary opacity-50 font-en" style="line-height:1;">01</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1"><a href="#" class="text-reset text-decoration-none hover-danger">২০২৬ সালের এইচএসসি পরীক্ষার সংশোধিত সিলেবাস প্রকাশ</a></h4>
                                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> ১ দিন আগে</small>
                                </div>
                            </div>
                            <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                <span class="fw-black fs-2 text-secondary opacity-50 font-en" style="line-height:1;">02</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1"><a href="#" class="text-reset text-decoration-none hover-danger">ফাইভ-জি চালুর প্রস্তুতি সম্পন্ন, শুরুতেই পাচ্ছে ৪ প্রধান শহর</a></h4>
                                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> ২ দিন আগে</small>
                                </div>
                            </div>
                            <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                <span class="fw-black fs-2 text-secondary opacity-50 font-en" style="line-height:1;">03</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1"><a href="#" class="text-reset text-decoration-none hover-danger">বিশ্ববাজারে স্বর্ণের দামে বড় ধরনের দরপতন</a></h4>
                                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> ২ দিন আগে</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TECHNOLOGY SECTION (Dark Styling) -->
        <section class="p-4 p-md-5 rounded-4 mb-5 position-relative overflow-hidden" style="background: #0B1220; color: #FFFFFF;" data-aos="fade-up">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="h4 fw-extrabold text-white border-start border-4 border-danger ps-2 m-0">টেকনোলজি ও এআই</h3>
                <span class="badge bg-outline-light border text-white">TECH PULSE</span>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <span class="badge bg-danger mb-2">কৃত্রিম বুদ্ধিমত্তা</span>
                        <h4 class="h5 fw-bold text-white"><a href="#" class="text-white text-decoration-none hover-danger">ওপেনএআই নতুন এআই মডেল 'GPT-5' নিয়ে আসছে শিগগিরই</a></h4>
                        <p class="text-light opacity-75 small">নতুন এই মডেলটিতে মানুষের চিন্তাশক্তির কাছাকাছি কাজ করার ক্ষমতা যুক্ত হতে যাচ্ছে।</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <span class="badge bg-info mb-2">সাইবার নিরাপত্তা</span>
                        <h4 class="h5 fw-bold text-white"><a href="#" class="text-white text-decoration-none hover-danger">স্মার্টফোনের সুরক্ষায় সতর্কবার্তা জারি করল সাইবার টিম</a></h4>
                        <p class="text-light opacity-75 small">ব্যাংকিং অ্যাপ ব্যবহারের ক্ষেত্রে পাসওয়ার্ড পরিবর্তন করার পরামর্শ।</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <span class="badge bg-warning text-dark mb-2">গ্যাজেট</span>
                        <h4 class="h5 fw-bold text-white"><a href="#" class="text-white text-decoration-none hover-danger">ব্যাটারি ছাড়া চলা পরিবেশবান্ধব স্মার্টওয়াচ</a></h4>
                        <p class="text-light opacity-75 small">শরীরের তাপ থেকে শক্তি রূপান্তর করে কাজ করবে এই নতুন ডিভাইস।</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- VIDEO NEWS SECTION (Swiper Slider) -->
        <section class="mb-5" data-aos="fade-up">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="h4 fw-extrabold border-start border-4 border-danger ps-2 m-0"><i class="fa-solid fa-circle-play text-danger me-1"></i> ভিডিও সংবাদ</h3>
            </div>
            <div class="swiper videoSwiper pb-4">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="glass-card overflow-hidden">
                            <div class="position-relative" style="height:200px;">
                                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=500&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Video 1">
                                <a href="#" class="position-absolute top-50 start-50 translate-middle text-white fs-1 opacity-90">
                                    <i class="fa-solid fa-circle-play text-danger bg-white rounded-circle p-1"></i>
                                </a>
                                <span class="badge bg-dark position-absolute bottom-0 end-0 m-2 font-en">04:15</span>
                            </div>
                            <div class="p-3">
                                <h5 class="h6 fw-bold m-0 line-clamp-2"><a href="#" class="text-reset text-decoration-none hover-danger">কক্সবাজার নতুন অর্থনৈতিক করিডোরের বিশেষ রিপোর্ট</a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="glass-card overflow-hidden">
                            <div class="position-relative" style="height:200px;">
                                <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=500&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Video 2">
                                <a href="#" class="position-absolute top-50 start-50 translate-middle text-white fs-1 opacity-90">
                                    <i class="fa-solid fa-circle-play text-danger bg-white rounded-circle p-1"></i>
                                </a>
                                <span class="badge bg-dark position-absolute bottom-0 end-0 m-2 font-en">02:40</span>
                            </div>
                            <div class="p-3">
                                <h5 class="h6 fw-bold m-0 line-clamp-2"><a href="#" class="text-reset text-decoration-none hover-danger">নতুন প্রযুক্তি মেলায় উদ্ভাবন করল বুয়েটের শিক্ষার্থীরা</a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="glass-card overflow-hidden">
                            <div class="position-relative" style="height:200px;">
                                <img src="https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=500&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Video 3">
                                <a href="#" class="position-absolute top-50 start-50 translate-middle text-white fs-1 opacity-90">
                                    <i class="fa-solid fa-circle-play text-danger bg-white rounded-circle p-1"></i>
                                </a>
                                <span class="badge bg-dark position-absolute bottom-0 end-0 m-2 font-en">05:10</span>
                            </div>
                            <div class="p-3">
                                <h5 class="h6 fw-bold m-0 line-clamp-2"><a href="#" class="text-reset text-decoration-none hover-danger">টাইগারদের অনুশীলনে নতুন স্পিন বোলিং কোচ</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <!-- ARTICLE READING DEMO SECTION -->
        <section id="article" class="pt-4 border-top" data-aos="fade-up">
            <div class="row g-5">
                <div class="col-lg-8">
                    <!-- Reading Progress Bar -->
                    <div id="readingProgress" class="position-fixed top-0 start-0 bg-danger" style="height: 4px; z-index: 2050; width: 0%;"></div>

                    <span class="badge bg-danger text-uppercase px-3 py-2 rounded-pill fw-bold mb-3">বিশেষ প্রতিবেদন</span>
                    
                    <h1 class="fw-black display-5 mb-3 lh-sm" style="font-size: calc(1.8rem + 1.5vw);">
                        স্মার্ট বাংলাদেশের ভবিষ্যৎ: কৃত্রিম বুদ্ধিমত্তা ও নতুন অর্থনৈতিক করিডোরের মহা পরিকল্পনা
                    </h1>
                    <p class="fs-5 text-muted mb-4 fw-medium">
                        প্রযুক্তি নির্ভর অর্থনীতি গড়ে তোলার লক্ষ্যে দেশজুড়ে তৈরি করা হচ্ছে অত্যাধুনিক কানেক্টিভিটি নেটওয়ার্ক ও উদ্ভাবনী ল্যাব।
                    </p>

                    <div class="glass-card p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=100&auto=format&fit=crop" class="rounded-circle object-fit-cover" style="width: 50px; height: 50px;" alt="Author">
                            <div>
                                <h6 class="fw-bold m-0">ফারহান আহমেদ</h6>
                                <small class="text-muted">বিশেষ প্রতিনিধি | ঢাকা</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 text-muted small">
                            <span><i class="fa-regular fa-calendar me-1"></i> ২৬ জুলাই ২০২৬</span>
                            <span><i class="fa-regular fa-clock me-1"></i> ৪ মিনিট পাঠ</span>
                            <span><i class="fa-regular fa-eye me-1"></i> ২৫,৪০০ পঠিত</span>
                        </div>
                    </div>

                    <!-- Reading Accessibility Actions -->
                    <div class="d-flex align-items-center justify-content-between p-2 mb-4 rounded-3 bg-body-tertiary">
                        <div class="d-flex align-items-center gap-2">
                            <span class="small fw-bold text-muted me-2">ফন্ট সাইজ:</span>
                            <button onclick="adjustFont(-1)" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:32px; height:32px;">A-</button>
                            <button onclick="adjustFont(1)" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:32px; height:32px;">A+</button>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-regular fa-bookmark"></i> সেভ করুন</button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="window.print()"><i class="fa-solid fa-print"></i> প্রিন্ট</button>
                        </div>
                    </div>

                    <div class="rounded-4 overflow-hidden mb-4 position-relative">
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=1200&auto=format&fit=crop" class="w-100 img-fluid" alt="Article Banner">
                    </div>

                    <article id="articleBody" class="article-content fs-5 lh-lg" style="color: var(--nh-text);">
                        <p>
                            বাংলাদেশের প্রযুক্তি খাতে এক নতুন দিগন্ত উন্মোচিত হতে যাচ্ছে। কৃত্রিম বুদ্ধিমত্তা (AI) এবং আধুনিক প্রযুক্তির সর্বোচ্চ ব্যবহার নিশ্চিত করতে নতুন এক অর্থনৈতিক পরিকল্পনা অনুমোদন করেছে সরকার।
                        </p>

                        <h2 class="fw-bold h3 my-4 border-start border-4 border-danger ps-3">ইনোভেশন হাব ও তরুণদের কর্মসংস্থান</h2>
                        <p>
                            নতুন এই করিডোরের আওতায় দেশের ৫০টি জেলায় তরুণদের জন্য বিশেষ কোডিং এবং এআই ট্রেনিং সেন্টার গড়ে তোলা হবে। এর ফলে আগামী ৫ বছরের মধ্যে দেশের ফ্রিল্যান্সিং ও সফটওয়্যার আইটি খাত থেকে ৫ বিলিয়ন ডলার রপ্তানি আয়ের লক্ষ্যমাত্রা নির্ধারণ করা হয়েছে।
                        </p>

                        <blockquote class="p-4 my-4 rounded-3 glass-panel border-start border-4 border-danger">
                            <p class="fst-italic fw-semibold mb-2">"তথ্যপ্রযুক্তির সঠিক ব্যবহার নিশ্চিত করা না গেলে ভবিষ্যৎ বৈশ্বিক অর্থনীতিতে প্রতিযোগিতায় টিকে থাকা কঠিন হবে। আমরা তরুণদের বিশ্বমানের দক্ষতায় রূপান্তর করতে চাই।"</p>
                            <footer class="blockquote-footer m-0 text-danger fw-bold">তথ্য ও যোগাযোগ প্রযুক্তি মন্ত্রী</footer>
                        </blockquote>
                    </article>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 90px;">
                        <div class="glass-card p-4">
                            <h5 class="fw-extrabold mb-3 border-start border-3 border-danger ps-2">সম্পর্কিত খবর</h5>
                            <div class="d-flex flex-column gap-3">
                                <a href="#" class="text-reset text-decoration-none border-bottom pb-2">
                                    <h6 class="fw-bold hover-danger m-0">আইটি পারার নিরাপত্তায় বিশেষ টিম গঠন</h6>
                                    <small class="text-muted">৩০ মিনিট আগে</small>
                                </a>
                                <a href="#" class="text-reset text-decoration-none border-bottom pb-2">
                                    <h6 class="fw-bold hover-danger m-0">ফাইভ-জি নেটওয়ার্ক সম্প্রসারণে নতুন পরিকল্পনা</h6>
                                    <small class="text-muted">১ ঘণ্টা আগে</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- NEWSLETTER CTA MODULE -->
        <section class="p-4 p-md-5 rounded-4 glass-panel text-white position-relative overflow-hidden mt-5" style="background: linear-gradient(135deg, #0B1220 0%, #111827 100%); border: 1px solid rgba(227, 27, 35, 0.3);">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-danger mb-2">নিউজলেটার</span>
                    <h3 class="fw-extrabold display-6 text-white mb-2">প্রতিদিনের গুরুত্বপূর্ণ খবর আপনার ইনবক্সে</h3>
                    <p class="text-light opacity-75 mb-3 mb-lg-0">কোনো ভুয়া খবর নয়, সারাদিনের বাছাই করা সেরা সংবাদের সারসংক্ষেপ পেতে সাবস্ক্রাইব করুন।</p>
                </div>
                <div class="col-lg-5">
                    <form action="#" method="POST" class="d-flex gap-2" onsubmit="event.preventDefault(); alert('ধন্যবাদ! আপনার সাবস্ক্রিপশন সফল হয়েছে।');">
                        <input type="email" class="form-control form-control-lg rounded-pill border-0 px-4" placeholder="আপনার ইমেইল লিখুন..." required>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold text-nowrap">সাবস্ক্রাইব →</button>
                    </form>
                    <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">আমরা আপনার তথ্যের সুরক্ষা নিশ্চিত করি। যেকোনো সময় আনসাবস্ক্রাইব করতে পারবেন।</small>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER SECTION -->
    <footer class="pt-5 pb-3 mt-5" style="background: var(--nh-primary); color: #9CA3AF;">
        <div class="container-fluid px-lg-5">
            <div class="row g-4 pb-4 border-bottom border-secondary">
                <div class="col-lg-4">
                    <h3 class="text-white fw-black h2 mb-2 font-en">NEWSHUB<span class="text-danger">PRO</span></h3>
                    <p class="small text-light opacity-75 mb-3">
                        বস্তুনিষ্ঠ খবরের নির্ভরযোগ্য ডিজিটাল প্ল্যাটফর্ম। নিরপেক্ষ সংবাদের নিশ্চয়তা দিয়ে আমরা পৌঁছে যাই সবার আগে।
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h5 class="text-white fw-bold mb-3">ক্যাটাগরি</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="#" class="text-reset text-decoration-none hover-white">বাংলাদেশ</a></li>
                        <li><a href="#" class="text-reset text-decoration-none hover-white">রাজনীতি</a></li>
                        <li><a href="#" class="text-reset text-decoration-none hover-white">আন্তর্জাতিক</a></li>
                        <li><a href="#" class="text-reset text-decoration-none hover-white">অর্থনীতি</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h5 class="text-white fw-bold mb-3">তথ্য ও যোগাযোগ</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="#" class="text-reset text-decoration-none hover-white">আমাদের সম্পর্কে</a></li>
                        <li><a href="#" class="text-reset text-decoration-none hover-white">বিজ্ঞাপন মূল্য তালিকা</a></li>
                        <li><a href="#" class="text-reset text-decoration-none hover-white">গোপনীয়তা নীতি</a></li>
                        <li><a href="#" class="text-reset text-decoration-none hover-white">যোগাযোগ</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h5 class="text-white fw-bold mb-3">মোবাইল অ্যাপস ডাউনলোড করুন</h5>
                    <p class="small text-muted">যেকোনো মুহূর্তে সর্বশেষ সংবাদ সরাসরি পেতে আমাদের অ্যাপ ডাউনলোড করুন।</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-3"><i class="fa-brands fa-google-play me-1"></i> Google Play</a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-3"><i class="fa-brands fa-apple me-1"></i> App Store</a>
                    </div>
                </div>
            </div>

            <div class="pt-3 d-flex flex-column flex-md-row align-items-center justify-content-between small">
                <p class="m-0">&copy; ২০২৬ NEWSHUB PRO. সর্বস্বত্ব সংরক্ষিত।</p>
                <p class="m-0 text-muted">ডিজাইন ও ডেভেলপমেন্ট: নিউজহাব টেক টিম</p>
            </div>
        </div>
    </footer>

    <!-- MOBILE BOTTOM APP NAVIGATION BAR -->
    <div class="mobile-bottom-nav">
        <a href="#" class="text-center text-decoration-none text-danger">
            <i class="fa-solid fa-house fs-5 d-block"></i>
            <span style="font-size: 0.7rem;">হোম</span>
        </a>
        <a href="#" class="text-center text-decoration-none text-muted">
            <i class="fa-solid fa-fire fs-5 d-block"></i>
            <span style="font-size: 0.7rem;">ট্রেন্ডিং</span>
        </a>
        <a href="#" class="text-center text-decoration-none text-muted">
            <i class="fa-solid fa-circle-play fs-5 d-block"></i>
            <span style="font-size: 0.7rem;">ভিডিও</span>
        </a>
        <a href="#" class="text-center text-decoration-none text-muted" onclick="openSearch()">
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
            <form action="#" method="GET" onsubmit="event.preventDefault(); alert('সার্চ সাবমিট হয়েছে');">
                <div class="input-group input-group-lg shadow-lg rounded-pill overflow-hidden bg-white p-1">
                    <input type="text" id="searchInput" class="form-control border-0 px-4 fs-4 focus-ring-0" placeholder="খবরের কীওয়ার্ড লিখুন..." required>
                    <button class="btn btn-danger rounded-pill px-4" type="submit">
                        <i class="fa-solid fa-magnifying-glass fs-4"></i>
                    </button>
                </div>
            </form>

            <div class="mt-4 text-start">
                <span class="text-muted small me-2">জনপ্রিয় অনুসন্ধান:</span>
                <div class="d-inline-flex flex-wrap gap-2 mt-2">
                    <a href="#" class="badge bg-secondary text-white text-decoration-none px-3 py-2 rounded-pill"># বাংলাদেশ</a>
                    <a href="#" class="badge bg-secondary text-white text-decoration-none px-3 py-2 rounded-pill"># এআই প্রযুক্তি</a>
                    <a href="#" class="badge bg-secondary text-white text-decoration-none px-3 py-2 rounded-pill"># ক্রিকেট বিশ্বকাপ</a>
                    <a href="#" class="badge bg-secondary text-white text-decoration-none px-3 py-2 rounded-pill"># শেয়ারবাজার</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS Scroll Animation
        AOS.init({ duration: 800, once: true });

        // Swiper Slider Init
        var swiper = new Swiper(".videoSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: { el: ".swiper-pagination", clickable: true },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });

        // Dark Mode Toggle Logic with LocalStorage
        const themeToggleBtn = document.getElementById('themeToggle');
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', currentTheme);
        updateThemeIcons(currentTheme);

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                let theme = document.documentElement.getAttribute('data-bs-theme');
                let targetTheme = theme === 'light' ? 'dark' : 'light';
                document.documentElement.setAttribute('data-bs-theme', targetTheme);
                localStorage.setItem('theme', targetTheme);
                updateThemeIcons(targetTheme);
            });
        }

        function updateThemeIcons(theme) {
            const icon = document.querySelector('#themeToggle i');
            if (icon) {
                icon.className = theme === 'dark' ? 'fa-solid fa-sun text-warning' : 'fa-solid fa-moon';
            }
        }

        // Fullscreen Search Overlay Functions
        function openSearch() {
            const el = document.getElementById('searchOverlay');
            el.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('searchInput').focus(), 100);
        }

        function closeSearch() {
            const el = document.getElementById('searchOverlay');
            el.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Article Reading Scroll Progress Indicator
        window.onscroll = function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            let progress = document.getElementById("readingProgress");
            if(progress) progress.style.width = scrolled + "%";
        };

        // Font Dynamic Resizing Logic
        let currentFontSize = 19;
        function adjustFont(delta) {
            currentFontSize += delta;
            if(currentFontSize >= 15 && currentFontSize <= 26) {
                document.getElementById("articleBody").style.fontSize = currentFontSize + "px";
            }
        }
    </script>
</body>
</html>

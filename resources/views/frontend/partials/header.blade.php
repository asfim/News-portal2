<!-- TOP INFORMATION BAR -->
<div class="topbar py-1 border-bottom d-none d-md-block" style="background: var(--nh-primary); color: #9CA3AF; font-size: 0.85rem;">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center">
            <div class="col-md-4">
                <span class="fw-bold text-white me-2">NEWSHUB PRO</span>
                <span class="border-end border-secondary me-2 pe-2"></span>
                <span><i class="fa-regular fa-clock me-1"></i> {{ date('l, d F Y') }}</span>
            </div>
            <div class="col-md-4 text-center">
                <span class="badge bg-danger me-1"><i class="fa-solid fa-location-dot"></i> ঢাকা</span>
                <span class="text-white fw-semibold">☀ ৩১° সে.</span>
                <span class="text-muted ms-2">আংশিক মেঘলা</span>
            </div>
            <div class="col-md-4 text-end">
                <div class="d-inline-flex align-items-center gap-3">
                    <a href="{{ \App\Models\Setting::get('facebook', '#') }}" class="text-reset hover-danger" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ \App\Models\Setting::get('youtube', '#') }}" class="text-reset hover-danger" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <a href="{{ \App\Models\Setting::get('instagram', '#') }}" class="text-reset hover-danger" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="{{ \App\Models\Setting::get('twitter', '#') }}" class="text-reset hover-danger" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                    <span class="border-end border-secondary h-100"></span>
                    <button id="themeToggle" class="btn btn-sm btn-link text-reset p-0 border-0" aria-label="Toggle Theme">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none fw-semibold ms-2">
                            <i class="fa-solid fa-gauge-high me-1"></i> ড্যাশবোর্ড
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white text-decoration-none fw-semibold ms-2">
                            <i class="fa-regular fa-user me-1"></i> লগইন
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN HEADER SECTION -->
<header class="py-3 border-bottom" style="background: var(--nh-surface);">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center">
            <div class="col-12 col-md-4">
                <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                    @if($logo = \App\Models\Setting::get('logo'))
                        <img src="{{ asset($logo) }}" alt="Logo" class="header-logo-img" style="max-height: 55px; width: auto; object-fit: contain;">
                    @else
                        <div class="bg-danger text-white fw-black px-2 px-sm-3 py-1 rounded-3 fs-3 font-en" style="letter-spacing: -1px;">
                            NH<span class="text-dark">P</span>
                        </div>
                        <div>
                            <h1 class="h3 fw-extrabold m-0 text-uppercase font-en header-logo-title" style="color: var(--nh-text); line-height: 1;">
                                NEWSHUB<span class="text-danger">PRO</span>
                            </h1>
                            <span class="text-muted d-block header-tagline">খবরের সাথে, সবসময়</span>
                        </div>
                    @endif
                </a>
            </div>
            <div class="col-md-4 d-none d-md-block text-center">
                <div class="p-1 rounded-3 text-center border border-dashed mx-auto overflow-hidden d-flex flex-column align-items-center justify-content-center" style="background: var(--nh-bg); font-size: 0.75rem; max-width: 300px; height: 60px;">
                    {!! str_replace('img-fluid', 'img-fluid h-100 w-100 object-fit-contain', renderAdSlot('header_banner', 'h-100 w-100')) !!}
                    @if(empty(renderAdSlot('header_banner')))
                        <span class="badge bg-secondary mb-1" style="font-size: 0.65rem;">বিজ্ঞাপন</span>
                        <span class="text-muted fw-semibold" style="font-size: 0.7rem;">স্টল বুকিং চলছে!</span>
                    @endif
                </div>
            </div>
            <div class="col-md-4 d-none d-md-block text-end">
                <div class="d-flex align-items-center justify-content-end gap-2 gap-md-3">
                    <button onclick="openSearch()" class="btn btn-outline-secondary rounded-circle" style="width:42px; height:42px;" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

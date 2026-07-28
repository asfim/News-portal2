@php
    $en_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $bn_days = ['রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
    $en_months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $bn_months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
    
    $en_num = ['0','1','2','3','4','5','6','7','8','9'];
    $bn_num = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

    $day = date('l');
    $day_num = date('d');
    $month = date('F');
    $year = date('Y');

    $bn_day = str_replace($en_days, $bn_days, $day);
    $bn_day_num = str_replace($en_num, $bn_num, $day_num);
    $bn_month = str_replace($en_months, $bn_months, $month);
    $bn_year = str_replace($en_num, $bn_num, $year);

    $full_bn_date = "ঢাকা, " . $bn_day_num . " " . $bn_month . " " . $bn_year;
@endphp

<div class="top-row">
    <div class="wrap justify-content-end">
        <div class="icons">
            <span id="bn-time"><i class="fa-regular fa-calendar me-1"></i> {{ $full_bn_date }}</span>
            <a href="{{ route('search') }}" title="खুঁজুন"><i class="fa-solid fa-magnifying-glass"></i></a>
            @auth
                <a href="{{ route('admin.dashboard') }}" title="ড্যাশবোর্ড"><i class="fa-regular fa-user"></i></a>
            @else
                <a href="{{ route('login') }}" title="লগইন"><i class="fa-regular fa-user"></i></a>
            @endauth
        </div>
    </div>
</div>

<div class="logo-row">
    <div class="wrap">
        <div class="search" style="cursor:pointer;" onclick="location.href='{{ route('search') }}'">
            <i class="fa-solid fa-magnifying-glass me-1"></i> {{ __('messages.search') }}
        </div>
        <div class="brand">
            <a href="{{ route('home') }}">
                <h1>{{ \App\Models\Setting::get('site_name', 'জনকথা') }}</h1>
            </a>
        </div>
        <div class="right-actions">
            {{-- Desktop right slot --}}
        </div>
        {{-- Mobile: hamburger + search icon --}}
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu" onclick="toggleMobileMenu()">
            <i class="fa-solid fa-bars" id="mobileMenuIcon"></i>
        </button>
    </div>
</div>


<script>
    function toggleMobileMenu() {
        const nav = document.querySelector('nav.cat-nav');
        const icon = document.getElementById('mobileMenuIcon');
        if (nav) {
            const isOpen = nav.classList.toggle('mobile-open');
            if (icon) {
                icon.className = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
            }
        }
    }
</script>

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
    <div class="wrap">
        <div style="display:flex;align-items:center;gap:16px;">
            <div class="hamburger" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="cats">
                <a href="{{ route('home') }}">হোম</a>
                @foreach (\App\Models\Category::where('status', true)->whereNull('parent_id')->orderBy('name', 'asc')->take(5)->get() as $cat)
                    <a href="{{ route('category', $cat->slug) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="icons">
            <span id="bn-time">{{ $full_bn_date }}</span>
            <a href="{{ route('search') }}">🔍</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" title="ড্যাশবোর্ড">👤</a>
            @else
                <a href="{{ route('login') }}" title="লগইন">👤</a>
            @endauth
        </div>
    </div>
</div>

<div class="logo-row">
    <div class="wrap">
        <div class="search" style="cursor:pointer;" onclick="location.href='{{ route('search') }}'">
            🔍 &nbsp;খুঁজুন
        </div>
        <div class="brand">
            <a href="{{ route('home') }}">
                <h1>{{ \App\Models\Setting::get('site_name', 'জনকথা') }}</h1>
            </a>
        </div>
        <div class="right-actions">
            <a href="{{ route('page.show', 'e-paper') }}" class="btn-outline">ই-পেপার</a>
            <span class="lang-toggle">EN</span>
        </div>
    </div>
</div>

<script>
    function toggleMobileMenu() {
        const nav = document.querySelector('nav.cat-nav');
        if (nav) {
            nav.style.display = nav.style.display === 'block' ? 'none' : 'block';
        }
    }
</script>

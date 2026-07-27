<footer>
    <div class="wrap foot-grid">
        <div class="brand2">
            <h1>{{ \App\Models\Setting::get('site_name', 'জনকথা') }}</h1>
            <p>{{ \App\Models\Setting::get('site_description', 'প্রতিদিনের বিশ্বাসযোগ্য সংবাদ, গভীর বিশ্লেষণ ও মতামত নিয়ে আপনার পাশে। এই পাতাটি একটি ডিজাইন প্রদর্শনী — এখানে ব্যবহৃত সব সংবাদ কাল্পনিক।') }}</p>
        </div>
        <div>
            <h5>বিভাগ</h5>
            <ul>
                @foreach(\App\Models\Category::whereNull('parent_id')->take(4)->get() as $cat)
                    <li><a href="{{ route('category', $cat->slug) }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h5>জীবনধারা</h5>
            <ul>
                @foreach(\App\Models\Category::whereNull('parent_id')->skip(4)->take(4)->get() as $cat)
                    <li><a href="{{ route('category', $cat->slug) }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h5>প্রতিষ্ঠান</h5>
            <ul>
                <li><a href="{{ route('page.show', 'about-us') }}">আমাদের সম্পর্কে</a></li>
                <li><a href="{{ route('page.show', 'contact') }}">যোগাযোগ</a></li>
                <li><a href="{{ route('page.show', 'ad-pricing') }}">বিজ্ঞাপন</a></li>
                <li><a href="{{ route('page.show', 'privacy-policy') }}">নীতিমালা</a></li>
            </ul>
        </div>
        <div>
            <h5>সামাজিক মাধ্যম</h5>
            <ul>
                <li><a href="{{ \App\Models\Setting::get('facebook', '#') }}" target="_blank">ফেসবুক</a></li>
                <li><a href="{{ \App\Models\Setting::get('youtube', '#') }}" target="_blank">ইউটিউব</a></li>
                <li><a href="{{ \App\Models\Setting::get('instagram', '#') }}" target="_blank">ইনস্টাগ্রাম</a></li>
                <li><a href="{{ \App\Models\Setting::get('twitter', '#') }}" target="_blank">টুইটার</a></li>
            </ul>
        </div>
    </div>
    <div class="wrap foot-bottom">
        <span>{{ \App\Models\Setting::get('footer_copyright', '© ২০২৬ ' . \App\Models\Setting::get('site_name', 'জনকথা') . '। সর্বস্বত্ব সংরক্ষিত।') }}</span>
        <span>ডিজাইন প্রোটোটাইপ — সব খবর কাল্পনিক ও উদাহরণস্বরূপ</span>
    </div>
</footer>

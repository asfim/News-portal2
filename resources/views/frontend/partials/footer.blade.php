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
                    <a href="{{ \App\Models\Setting::get('facebook', '#') }}" class="btn btn-sm btn-outline-light rounded-circle" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ \App\Models\Setting::get('youtube', '#') }}" class="btn btn-sm btn-outline-light rounded-circle" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <a href="{{ \App\Models\Setting::get('twitter', '#') }}" class="btn btn-sm btn-outline-light rounded-circle" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h5 class="text-white fw-bold mb-3">ক্যাটাগরি</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    @foreach(\App\Models\Category::whereNull('parent_id')->take(4)->get() as $cat)
                        <li><a href="{{ route('category', $cat->slug) }}" class="text-reset text-decoration-none hover-white">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h5 class="text-white fw-bold mb-3">তথ্য ও যোগাযোগ</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="{{ route('page.show', 'about-us') }}" class="text-reset text-decoration-none hover-white">আমাদের সম্পর্কে</a></li>
                    <li><a href="{{ route('page.show', 'ad-pricing') }}" class="text-reset text-decoration-none hover-white">বিজ্ঞাপন মূল্য তালিকা</a></li>
                    <li><a href="{{ route('page.show', 'privacy-policy') }}" class="text-reset text-decoration-none hover-white">গোপনীয়তা নীতি</a></li>
                    <li><a href="{{ route('page.show', 'contact') }}" class="text-reset text-decoration-none hover-white">যোগাযোগ</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h5 class="text-white fw-bold mb-3">মোবাইল অ্যাপস ডাউনলোড করুন</h5>
                <p class="small text-white ">যেকোনো মুহূর্তে সর্বশেষ সংবাদ সরাসরি পেতে আমাদের অ্যাপ ডাউনলোড করুন।</p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-3"><i class="fa-brands fa-google-play me-1"></i> Google Play</a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-3"><i class="fa-brands fa-apple me-1"></i> App Store</a>
                </div>
            </div>
        </div>

        <div class="pt-3 d-flex flex-column flex-md-row align-items-center justify-content-between small">
            <p class="m-0">{{ \App\Models\Setting::get('footer_copyright', '© '.date('Y').' NEWSHUB PRO. সর্বস্বত্ব সংরক্ষিত।') }}</p>
            <p class="m-0 text-white">ডিজাইন ও ডেভেলপমেন্ট: নিউজহাব টেক টিম</p>
        </div>
    </div>
</footer>

<footer>
    <div class="wrap foot-grid">
        <div class="brand2">
            <h1>{{ app()->getLocale() == 'en' ? \App\Models\Setting::get('site_name_en', \App\Models\Setting::get('site_name', 'Jonokotha')) : \App\Models\Setting::get('site_name', 'জনকথা') }}</h1>
            <p>{{ app()->getLocale() == 'en' ? \App\Models\Setting::get('site_description_en', 'Trusted daily news, deep analysis and opinion with you.') : \App\Models\Setting::get('site_description', 'প্রতিদিনের বিশ্বাসযোগ্য সংবাদ, গভীর বিশ্লেষণ ও মতামত নিয়ে আপনার পাশে। এই পাতাটি একটি ডিজাইন প্রদর্শনী — এখানে ব্যবহৃত সব সংবাদ কাল্পনিক।') }}</p>
        </div>
        @php
            $footerCats1 = \App\Models\Category::whereNull('parent_id')->take(4)->get();
            $footerCats2 = \App\Models\Category::whereNull('parent_id')->skip(4)->take(4)->get();
        @endphp
        
        @if($footerCats1->count() > 0)
        <div>
            <h5>@lang('messages.sections')</h5>
            <ul>
                @foreach($footerCats1 as $cat)
                    <li><a href="{{ route('category', $cat->slug) }}">{{ $cat->translated_name }}</a></li>
                @endforeach
            </ul>
        </div>
        @endif
        
        @if($footerCats2->count() > 0)
        <div>
            <h5>@lang('messages.lifestyle')</h5>
            <ul>
                @foreach($footerCats2 as $cat)
                    <li><a href="{{ route('category', $cat->slug) }}">{{ $cat->translated_name }}</a></li>
                @endforeach
            </ul>
        </div>
        @endif
        <div>
            <h5>@lang('messages.organization')</h5>
            <ul>
                @foreach(\App\Models\Page::where('status', true)->get() as $page)
                    <li><a href="{{ route('page.show', $page->slug) }}">{{ $page->translated_title }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h5>@lang('messages.social_media')</h5>
            <ul style="flex-direction: row; gap: 15px;">
                @if(\App\Models\Setting::get('facebook'))
                    <li><a href="{{ \App\Models\Setting::get('facebook') }}" target="_blank" title="@lang('messages.facebook')"><i class="fa-brands fa-facebook fa-xl"></i></a></li>
                @endif
                @if(\App\Models\Setting::get('youtube'))
                    <li><a href="{{ \App\Models\Setting::get('youtube') }}" target="_blank" title="@lang('messages.youtube')"><i class="fa-brands fa-youtube fa-xl"></i></a></li>
                @endif
                @if(\App\Models\Setting::get('instagram'))
                    <li><a href="{{ \App\Models\Setting::get('instagram') }}" target="_blank" title="@lang('messages.instagram')"><i class="fa-brands fa-instagram fa-xl"></i></a></li>
                @endif
                @if(\App\Models\Setting::get('twitter'))
                    <li><a href="{{ \App\Models\Setting::get('twitter') }}" target="_blank" title="@lang('messages.twitter')"><i class="fa-brands fa-twitter fa-xl"></i></a></li>
                @endif
            </ul>
        </div>
    </div>
    <div class="wrap foot-bottom">
        <span>
            @if(app()->getLocale() == 'en')
                © {{ date('Y') }} {{ \App\Models\Setting::get('site_name_en', \App\Models\Setting::get('site_name', 'Jonokotha')) }}. @lang('messages.all_rights_reserved')
            @else
                {{ \App\Models\Setting::get('footer_copyright', '© ২০২৬ ' . \App\Models\Setting::get('site_name', 'জনকথা') . '। সর্বস্বত্ব সংরক্ষিত।') }}
            @endif
        </span>
        <span>@lang('messages.design_prototype')</span>
    </div>
</footer>

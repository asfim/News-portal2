<nav class="cat-nav sticky-top" style="z-index: 1040; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
    <div class="wrap">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">সর্বশেষ</a>
        @foreach (\App\Models\Category::where('status', true)->whereNull('parent_id')->orderBy('name', 'asc')->get() as $category)
            <a href="{{ route('category', $category->slug) }}" class="{{ request()->is('category/' . $category->slug) ? 'active' : '' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</nav>

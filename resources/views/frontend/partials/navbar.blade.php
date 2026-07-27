<nav class="cat-nav">
    <div class="wrap">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">সর্বশেষ</a>
        @foreach (\App\Models\Category::where('status', true)->whereNull('parent_id')->orderBy('name', 'asc')->get() as $category)
            <a href="{{ route('category', $category->slug) }}" class="{{ request()->is('category/' . $category->slug) ? 'active' : '' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</nav>

@extends('layouts.app')

@section('title', __('messages.quick_news') . ' | ' . \App\Models\Setting::get(app()->getLocale() == 'en' ? 'site_name_en' : 'site_name', 'Jonokotha'))

@section('content')
<main class="container-fluid px-lg-5 py-4">
    <!-- Page Header -->
    <section class="mb-4">
        <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-secondary-subtle">
            <h1 class="h3 fw-extrabold m-0 border-start border-4 border-danger ps-3">@lang('messages.all_quick_news')</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('messages.quick_news')</li>
                </ol>
            </nav>
        </div>
        <p class="text-muted mt-3">@lang('messages.quick_news_subtitle')</p>
    </section>

    <!-- Category Grid -->
    <section class="mb-5">
        @if($categorySections->count() > 0)
            <div class="row g-4">
                @foreach($categorySections as $cat)
                    @php $newsItem = $cat->news->first(); @endphp
                    @if($newsItem)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="glass-card h-100 overflow-hidden d-flex flex-column hover-lift">
                            <div class="img-zoom-container position-relative ratio ratio-16x9">
                                <x-news-thumbnail :news="$newsItem" classes="object-fit-cover" />
                                <div class="position-absolute m-2" style="top:0; left:0; z-index:10; width:auto; height:auto;">
                                    <span class="badge bg-danger px-2 py-1 fs-7 fw-bold">
                                        <a href="{{ route('category', $cat->slug) }}" class="text-white text-decoration-none">{{ $cat->translated_name }}</a>
                                    </span>
                                </div>
                            </div>
                            <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                                <h4 class="h6 fw-bold mb-2 line-clamp-2">
                                    <a href="{{ route('news.show', $newsItem->slug) }}" class="text-reset text-decoration-none hover-danger">{{ $newsItem->translated_title }}</a>
                                </h4>
                                <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> {{ $newsItem->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-3"><i class="fa-solid fa-layer-group"></i></div>
                <h3 class="fw-bold text-muted">@lang('messages.no_categories')</h3>
                <p class="text-secondary">@lang('messages.no_quick_news_desc')</p>
                <a href="{{ route('home') }}" class="btn btn-danger px-4 py-2 rounded-pill mt-3">@lang('messages.back_to_home')</a>
            </div>
        @endif
    </section>

</main>
@endsection

@extends('layouts.app')

@section('title', __('messages.latest_news') . ' | ' . \App\Models\Setting::get(app()->getLocale() == 'en' ? 'site_name_en' : 'site_name', 'Jonokotha'))

@section('content')
<main class="container-fluid px-lg-5 py-4">
    <!-- Page Header -->
    <section class="mb-4">
        <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-secondary-subtle">
            <h1 class="h3 fw-extrabold m-0 border-start border-4 border-danger ps-3">@lang('messages.latest_news')</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('messages.latest_news')</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- News Grid -->
    <section class="mb-5">
        @if($news->count() > 0)
            <div class="row g-4">
                @foreach($news as $item)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="glass-card h-100 overflow-hidden d-flex flex-column hover-lift">
                        <div class="img-zoom-container position-relative ratio ratio-16x9">
                            <x-news-thumbnail :news="$item" classes="object-fit-cover" />
                            @if($item->category)
                            <div class="position-absolute m-2" style="top:0; left:0; z-index:10; width:auto; height:auto;">
                                <span class="badge bg-danger px-2 py-1 fs-7 fw-bold">
                                    <a href="{{ route('category', $item->category->slug) }}" class="text-white text-decoration-none">{{ $item->category->translated_name }}</a>
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <h4 class="h5 fw-bold mb-2 line-clamp-2">
                                    <a href="{{ route('news.show', $item->slug) }}" class="text-reset text-decoration-none hover-danger">{{ $item->translated_title }}</a>
                                </h4>
                                <p class="text-muted small line-clamp-3 mb-3">{{ $item->translated_short_description }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between text-muted small border-top pt-2 mt-auto">
                                <span><i class="fa-regular fa-clock me-1"></i> {{ $item->created_at->diffForHumans() }}</span>
                                <span><i class="fa-regular fa-eye me-1"></i> {{ number_format($item->views) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $news->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-3"><i class="fa-regular fa-newspaper"></i></div>
                <h3 class="fw-bold text-muted">@lang('messages.no_news_found')</h3>
                <p class="text-secondary">@lang('messages.no_latest_news')</p>
                <a href="{{ route('home') }}" class="btn btn-danger px-4 py-2 rounded-pill mt-3">@lang('messages.back_to_home')</a>
            </div>
        @endif
    </section>

</main>
@endsection

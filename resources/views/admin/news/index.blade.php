@extends('layouts.admin')

@section('title', 'All Articles')

@section('content')
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Articles</h2>
                <p class="text-secondary mb-0">Manage and moderate all portal news articles.</p>
            </div>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Create Article
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search & Filter Card -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.news.index') }}" method="GET" class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label text-secondary small fw-semibold">Search Title</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-secondary"><i
                                    class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" class="form-control bg-light border-0" name="search"
                                value="{{ request('search') }}" placeholder="Search title...">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label text-secondary small fw-semibold">Category</label>
                        <select class="form-select bg-light border-0" name="category_id">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label text-secondary small fw-semibold">Author</label>
                        <select class="form-select bg-light border-0" name="author_id">
                            <option value="">All Authors</option>
                            @foreach ($authors as $auth)
                                <option value="{{ $auth->id }}"
                                    {{ request('author_id') == $auth->id ? 'selected' : '' }}>{{ $auth->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label text-secondary small fw-semibold">Status</label>
                        <select class="form-select bg-light border-0" name="status">
                            <option value="">All Status</option>
                            @foreach (['draft', 'pending', 'approved', 'published', 'scheduled', 'rejected', 'archived'] as $st)
                                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                                    {{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-12 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-secondary w-100 fw-semibold">Filter</button>
                        @if (request()->anyFilled(['search', 'category_id', 'author_id', 'status']))
                            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary px-3"><i
                                    class="fa-solid fa-rotate-left"></i></a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- News Table Card -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-0">
                            <tr>
                                <th class="px-4 py-3 border-0" style="width: 100px;">Image</th>
                                <th class="py-3 border-0">Article Title</th>
                                <th class="py-3 border-0">Category</th>
                                <th class="py-3 border-0">Author</th>
                                <th class="py-3 border-0">Featured Tags</th>
                                <th class="py-3 border-0">Status</th>
                                <th class="py-3 border-0 text-center">Views</th>
                                <th class="px-4 py-3 border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($news->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-secondary">No articles found.</td>
                                </tr>
                            @else
                                @foreach ($news as $item)
                                    <tr class="border-bottom border-light">
                                        <td class="px-4 py-3">
                                            @if ($item->featuredImage)
                                                <img src="{{ $item->featuredImage->path }}" alt="{{ $item->title }}"
                                                    class="rounded-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            @elseif (!empty($item->video_url))
                                                @if(str_starts_with($item->video_url, '/storage/'))
                                                    <video src="{{ asset($item->video_url) }}#t=0.1" class="rounded-3" style="width: 50px; height: 50px; object-fit: cover;" muted preload="metadata"></video>
                                                @else
                                                    <div class="bg-dark text-danger rounded-3 d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 50px;">
                                                        <i class="fa-brands fa-youtube fs-4"></i>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="bg-light text-secondary rounded-3 d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="fa-regular fa-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3" style="max-width: 280px;">
                                            <div class="fw-semibold text-dark text-truncate">{{ $item->title }}</div>
                                            <span
                                                class="small text-secondary">{{ $item->created_at->format('M d, Y H:i') }}</span>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                class="badge bg-secondary bg-opacity-10 text-secondary">{{ $item->category->name }}</span>
                                        </td>
                                        <td class="py-3 text-secondary small">{{ $item->author->name }}</td>
                                        <td class="py-3">
                                            <div class="d-flex flex-wrap gap-1">
                                                @if ($item->breaking_news)
                                                    <span class="badge bg-danger py-1 px-2"
                                                        style="font-size: 0.7rem;">Breaking</span>
                                                @endif
                                                @if ($item->featured_news)
                                                    <span class="badge bg-primary py-1 px-2"
                                                        style="font-size: 0.7rem;">Featured</span>
                                                @endif
                                                @if ($item->trending_news)
                                                    <span class="badge bg-warning text-dark py-1 px-2"
                                                        style="font-size: 0.7rem;">Trending</span>
                                                @endif
                                                @if ($item->is_latest)
                                                    <span class="badge bg-info text-dark py-1 px-2"
                                                        style="font-size: 0.7rem;">Latest</span>
                                                @endif
                                                @if (!$item->breaking_news && !$item->featured_news && !$item->trending_news && !$item->is_latest)
                                                    <span class="text-secondary small">Standard</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            @switch($item->status)
                                                @case('published')
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">Published</span>
                                                @break

                                                @case('pending')
                                                    <span
                                                        class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">Pending</span>
                                                @break

                                                @case('draft')
                                                    <span
                                                        class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">Draft</span>
                                                @break

                                                @case('scheduled')
                                                    <span
                                                        class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">Scheduled</span>
                                                @break

                                                @default
                                                    <span
                                                        class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">{{ ucfirst($item->status) }}</span>
                                            @endswitch
                                        </td>
                                        <td class="py-3 text-center fw-semibold text-secondary small">
                                            {{ number_format($item->views) }}</td>
                                        <td class="px-4 py-3 text-end">
                                            <a href="{{ route('admin.news.edit', $item->id) }}"
                                                class="btn btn-light btn-sm text-secondary border-0"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this article?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-light btn-sm text-danger border-0 ms-1"><i
                                                        class="fa-regular fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                @if ($news->hasPages())
                    <div class="p-4 border-top border-light">
                        {{ $news->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

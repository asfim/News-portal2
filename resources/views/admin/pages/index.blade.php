@extends('layouts.admin')

@section('title', 'Static Pages')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Static Pages</h2>
            <p class="text-secondary mb-0">Manage information pages like About Us, Privacy Policy, Terms of Service.</p>
        </div>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Add Page
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Panel -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.pages.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control bg-light border-0" name="search" value="{{ request('search') }}" placeholder="Search pages by title or slug...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100 fw-semibold rounded-3">Search</button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary w-100 fw-semibold rounded-3">Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Pages Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-0">
                        <tr>
                            <th class="px-4 py-3 border-0" style="width: 80px;">#</th>
                            <th class="py-3 border-0">Page Title</th>
                            <th class="py-3 border-0">Slug</th>
                            <th class="py-3 border-0">Updated At</th>
                            <th class="py-3 border-0" style="width: 120px;">Status</th>
                            <th class="px-4 py-3 border-0 text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pages->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary">No pages found.</td>
                            </tr>
                        @else
                            @foreach($pages as $index => $page)
                                <tr class="border-bottom border-light">
                                    <td class="px-4 py-3 text-secondary">{{ ($pages->currentPage() - 1) * $pages->perPage() + $index + 1 }}</td>
                                    <td class="py-3 fw-semibold text-dark">{{ $page->title }}</td>
                                    <td class="py-3 text-secondary"><code>/{{ $page->slug }}</code></td>
                                    <td class="py-3 text-secondary small">{{ $page->updated_at->format('M d, Y') }}</td>
                                    <td class="py-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $page->id }}" {{ $page->status ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-light btn-sm text-secondary border-0"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this static page?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger border-0 ms-1"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            @if($pages->hasPages())
                <div class="p-4 border-top border-light">
                    {{ $pages->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Handles inline status toggle requests
    document.querySelectorAll('.status-toggle').forEach(element => {
        element.addEventListener('change', function () {
            const id = this.getAttribute('data-id');
            fetch(`/admin/pages/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Feedback hook
                }
            });
        });
    });
</script>
@endsection

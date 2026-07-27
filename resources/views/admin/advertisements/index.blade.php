@extends('layouts.admin')

@section('title', 'Advertisements Management')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Advertisements</h2>
            <p class="text-secondary mb-0">Manage ad slots, header banners, sidebar widgets, and custom AdSense scripts.</p>
        </div>
        <a href="{{ route('admin.advertisements.create') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Add Advertisement
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
            <form action="{{ route('admin.advertisements.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control bg-light border-0" name="search" value="{{ request('search') }}" placeholder="Search ads by title or placement key...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100 fw-semibold rounded-3">Search</button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.advertisements.index') }}" class="btn btn-outline-secondary w-100 fw-semibold rounded-3">Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Advertisements Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-0">
                        <tr>
                            <th class="px-4 py-3 border-0" style="width: 80px;">Preview</th>
                            <th class="py-3 border-0">Campaign Title</th>
                            <th class="py-3 border-0">Placement Spot</th>
                            <th class="py-3 border-0">Ad Type</th>
                            <th class="py-3 border-0">Date Range</th>
                            <th class="py-3 border-0" style="width: 120px;">Status</th>
                            <th class="px-4 py-3 border-0 text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($advertisements->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center py-5 text-secondary">No ads registered.</td>
                            </tr>
                        @else
                            @foreach($advertisements as $ad)
                                <tr class="border-bottom border-light">
                                    <td class="px-4 py-3">
                                        @if($ad->type === 'image' && $ad->image_path)
                                            <img src="{{ asset($ad->image_path) }}" alt="ad" class="rounded border" style="width: 60px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary bg-opacity-10 text-secondary rounded d-flex align-items-center justify-content-center small" style="width: 60px; height: 40px;">
                                                <i class="fa-solid fa-code"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 fw-semibold text-dark">{{ $ad->title }}</td>
                                    <td class="py-3">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary"><code>{{ $ad->placement_key }}</code></span>
                                    </td>
                                    <td class="py-3 text-secondary text-capitalize small">{{ $ad->type }}</td>
                                    <td class="py-3 text-secondary small">
                                        @if($ad->start_date && $ad->end_date)
                                            {{ \Carbon\Carbon::parse($ad->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($ad->end_date)->format('M d, Y') }}
                                        @else
                                            <span class="text-secondary opacity-75">No limits (Always active)</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $ad->id }}" {{ $ad->status ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('admin.advertisements.edit', $ad->id) }}" class="btn btn-light btn-sm text-secondary border-0"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <form action="{{ route('admin.advertisements.destroy', $ad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this ad campaign?')">
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

            @if($advertisements->hasPages())
                <div class="p-4 border-top border-light">
                    {{ $advertisements->links() }}
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
            fetch(`/admin/advertisements/${id}/toggle-status`, {
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

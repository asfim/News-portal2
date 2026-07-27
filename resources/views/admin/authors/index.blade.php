@extends('layouts.admin')

@section('title', 'Author Management')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Authors & Reporters</h2>
            <p class="text-secondary mb-0">Manage news reporters, journalists, and staff writer profiles.</p>
        </div>
        <a href="{{ route('admin.authors.create') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Add Author
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
            <form action="{{ route('admin.authors.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control bg-light border-0" name="search" value="{{ request('search') }}" placeholder="Search authors by name, username, email or designation...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100 fw-semibold rounded-3">Search</button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.authors.index') }}" class="btn btn-outline-secondary w-100 fw-semibold rounded-3">Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Authors Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-0">
                        <tr>
                            <th class="px-4 py-3 border-0">Photo</th>
                            <th class="py-3 border-0">Name / Designation</th>
                            <th class="py-3 border-0">Username / Email</th>
                            <th class="py-3 border-0">Linked User Account</th>
                            <th class="py-3 border-0">Social Links</th>
                            <th class="py-3 border-0" style="width: 120px;">Status</th>
                            <th class="px-4 py-3 border-0 text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($authors->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center py-5 text-secondary">No author profiles found.</td>
                            </tr>
                        @else
                            @foreach($authors as $author)
                                <tr class="border-bottom border-light">
                                    <td class="px-4 py-3">
                                        @if($author->profile_photo)
                                            <img src="{{ $author->profile_photo }}" alt="{{ $author->name }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid var(--border-color);">
                                        @else
                                            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; border: 2px solid var(--border-color);">
                                                {{ substr($author->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-semibold text-dark">{{ $author->name }}</div>
                                        <span class="small text-secondary">{{ $author->designation ?? 'Writer' }}</span>
                                    </td>
                                    <td class="py-3">
                                        <div class="small text-dark">{{ $author->username }}</div>
                                        <span class="small text-secondary" style="font-size: 0.8rem;">{{ $author->email }}</span>
                                    </td>
                                    <td class="py-3">
                                        @if($author->user)
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill"><i class="fa-regular fa-user me-1"></i> {{ $author->user->name }}</span>
                                        @else
                                            <span class="text-secondary small">Standalone Profile</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex gap-2">
                                            @if($author->facebook)
                                                <a href="{{ $author->facebook }}" target="_blank" class="text-primary small"><i class="fa-brands fa-facebook"></i></a>
                                            @endif
                                            @if($author->twitter)
                                                <a href="{{ $author->twitter }}" target="_blank" class="text-dark small"><i class="fa-brands fa-x-twitter"></i></a>
                                            @endif
                                            @if($author->instagram)
                                                <a href="{{ $author->instagram }}" target="_blank" class="text-danger small"><i class="fa-brands fa-instagram"></i></a>
                                            @endif
                                            @if($author->linkedin)
                                                <a href="{{ $author->linkedin }}" target="_blank" class="text-primary small"><i class="fa-brands fa-linkedin"></i></a>
                                            @endif
                                            @if(!$author->facebook && !$author->twitter && !$author->instagram && !$author->linkedin)
                                                <span class="text-secondary small">None</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $author->id }}" {{ $author->status ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn btn-light btn-sm text-secondary border-0"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this author profile?')">
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

            @if($authors->hasPages())
                <div class="p-4 border-top border-light">
                    {{ $authors->links() }}
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
            fetch(`/admin/authors/${id}/toggle-status`, {
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

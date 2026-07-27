@extends('layouts.admin')

@section('title', 'Category Management')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Categories</h2>
            <p class="text-secondary mb-0">Manage news categories and nested subcategories.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control bg-light border-0" name="search" value="{{ request('search') }}" placeholder="Search categories, subcategories or slugs...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100 fw-semibold rounded-3">Search</button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary w-100 fw-semibold rounded-3">Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Category Listing -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-0">
                        <tr>
                            <th class="px-4 py-3 border-0">Icon / Image</th>
                            <th class="py-3 border-0">Category Name</th>
                            <th class="py-3 border-0">Slug</th>
                            <th class="py-3 border-0">Sort Order</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="px-4 py-3 border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($categories->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary">No categories found.</td>
                            </tr>
                        @else
                            @foreach($categories as $category)
                                <!-- Parent Category Row -->
                                <tr class="border-bottom border-light fw-medium">
                                    <td class="px-4 py-3">
                                        @if($category->image)
                                            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="rounded-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        @elseif($category->icon)
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="{{ $category->icon }} fs-5"></i>
                                            </div>
                                        @else
                                            <div class="bg-light text-secondary rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fa-regular fa-folder fs-5"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <div class="text-dark">{{ $category->name }}</div>
                                        <span class="badge bg-primary bg-opacity-10 text-primary small mt-1">Parent Category</span>
                                    </td>
                                    <td class="py-3 text-secondary">{{ $category->slug }}</td>
                                    <td class="py-3">{{ $category->sort_order }}</td>
                                    <td class="py-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $category->id }}" {{ $category->status ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-light btn-sm text-secondary border-0"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category? All its subcategories will be detached.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger border-0 ms-1"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Subcategories Loop -->
                                @if($category->children->isNotEmpty())
                                    @foreach($category->children as $child)
                                        <tr class="border-bottom border-light-subtle bg-light bg-opacity-25">
                                            <td class="px-4 py-3 ps-5">
                                                <div class="ps-3 d-flex align-items-center gap-2">
                                                    <i class="fa-solid fa-arrow-turn-up text-secondary opacity-50 rotate-90"></i>
                                                    @if($child->image)
                                                        <img src="{{ $child->image }}" alt="{{ $child->name }}" class="rounded-3" style="width: 32px; height: 32px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light text-secondary rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fa-regular fa-folder-open small"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="text-secondary fw-semibold">{{ $child->name }}</div>
                                            </td>
                                            <td class="py-3 text-secondary" style="font-size: 0.85rem;">{{ $child->slug }}</td>
                                            <td class="py-3">{{ $child->sort_order }}</td>
                                            <td class="py-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $child->id }}" {{ $child->status ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <a href="{{ route('admin.categories.edit', $child->id) }}" class="btn btn-light btn-sm text-secondary border-0"><i class="fa-regular fa-pen-to-square"></i></a>
                                                <form action="{{ route('admin.categories.destroy', $child->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light btn-sm text-danger border-0 ms-1"><i class="fa-regular fa-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            
            @if($categories->hasPages())
                <div class="p-4 border-top border-light">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .rotate-90 {
        transform: rotate(90deg);
    }
</style>

<script>
    // Handles inline status toggle requests
    document.querySelectorAll('.status-toggle').forEach(element => {
        element.addEventListener('change', function () {
            const id = this.getAttribute('data-id');
            fetch(`/admin/categories/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Flash feedback toast or alert if needed
                }
            });
        });
    });
</script>
@endsection

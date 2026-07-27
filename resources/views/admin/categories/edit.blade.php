@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Edit Category</h2>
            <p class="text-secondary mb-0">Modify the category settings.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-5">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- General Details Column -->
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-secondary">Category Name</label>
                            <input type="text" class="form-control py-3" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="Enter category name" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="form-label fw-semibold text-secondary">Slug (SEO URL)</label>
                            <input type="text" class="form-control py-3" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="auto-generated-slug" required>
                        </div>

                        <div class="mb-4">
                            <label for="parent_id" class="form-label fw-semibold text-secondary">Parent Category</label>
                            <select class="form-select py-3" id="parent_id" name="parent_id">
                                <option value="">None (Make it a Parent Category)</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                @endforeach
                            </select>
                            <span class="small text-secondary">Select a parent if you are creating a subcategory.</span>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold text-secondary">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter category details...">{{ old('description', $category->description) }}</textarea>
                        </div>
                    </div>

                    <!-- Sidebar Styling & Meta Info Column -->
                    <div class="col-lg-4">
                        <div class="card bg-light bg-opacity-25 border-0 p-4 rounded-3 mb-4">
                            <h5 class="fw-bold text-dark mb-4">Display Options</h5>

                            <div class="mb-4">
                                <label for="icon" class="form-label fw-semibold text-secondary">FontAwesome Icon Class</label>
                                <input type="text" class="form-control py-3" id="icon" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="fa-solid fa-sports">
                            </div>

                            <div class="mb-4">
                                <label for="sort_order" class="form-label fw-semibold text-secondary">Sort Order</label>
                                <input type="number" class="form-control py-3" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                            </div>

                            <div class="mb-4">
                                <label for="image_upload" class="form-label fw-semibold text-secondary">Featured Image</label>
                                <input type="file" class="form-control mb-3" id="image_upload" name="image_upload">
                                @if($category->image)
                                    <div class="p-2 bg-white rounded-3 border d-inline-block">
                                        <img src="{{ $category->image }}" alt="Category image" style="max-height: 80px;">
                                    </div>
                                @endif
                            </div>

                            <div class="form-check form-switch ps-0 mb-2">
                                <label class="form-check-label fw-semibold text-dark fs-6" for="status">Active Status</label>
                                <div class="text-secondary small mb-2">Toggle to show/hide category on menu lists.</div>
                                <input class="form-check-input ms-0 border-secondary-subtle" style="width: 2.5em; height: 1.25em;" type="checkbox" id="status" name="status" value="1" {{ old('status', $category->status ? '1' : '0') == '1' ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="card bg-light bg-opacity-25 border-0 p-4 rounded-3">
                            <h5 class="fw-bold text-dark mb-4">SEO Details (Optional)</h5>

                            <div class="mb-3">
                                <label for="meta_title" class="form-label fw-semibold text-secondary">SEO Meta Title</label>
                                <input type="text" class="form-control py-3" id="meta_title" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" placeholder="Title for Search Engines">
                            </div>

                            <div>
                                <label for="meta_description" class="form-label fw-semibold text-secondary">SEO Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Snippet for search pages">{{ old('meta_description', $category->meta_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top border-light mt-5 pt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Automatic SEO Slug Generator
    document.getElementById('name').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '') // remove special characters
            .replace(/\s+/g, '-')         // replace spaces with hyphens
            .replace(/-+/g, '-');         // remove duplicate hyphens
        document.getElementById('slug').value = slug;
    });
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Add Subcategory')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Add Subcategory</h2>
            <p class="text-secondary mb-0">Create a child subcategory and link to parent category node.</p>
        </div>
        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
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
            <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label for="parent_id" class="form-label fw-semibold text-secondary">Parent Category</label>
                            <select class="form-select py-3" id="parent_id" name="parent_id" required>
                                <option value="">Select Parent Category</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-secondary">Subcategory Name</label>
                            <input type="text" class="form-control py-3" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. National, International, Cricket" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="form-label fw-semibold text-secondary">Slug (SEO URL)</label>
                            <input type="text" class="form-control py-3" id="slug" name="slug" value="{{ old('slug') }}" placeholder="auto-generated-slug" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold text-secondary">Description (Optional)</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Brief details about subcategory...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-light bg-opacity-25 border-0 p-4 rounded-3 mb-4">
                            <h5 class="fw-bold text-dark mb-4">Settings</h5>

                            <div class="mb-4">
                                <label for="image_upload" class="form-label fw-semibold text-secondary">Banner Image</label>
                                <input type="file" class="form-control" id="image_upload" name="image_upload">
                            </div>

                            <div class="mb-4">
                                <label for="sort_order" class="form-label fw-semibold text-secondary">Display Sort Order</label>
                                <input type="number" class="form-control py-3" id="sort_order" name="sort_order" value="{{ old('sort_order', '0') }}" required>
                            </div>

                            <div class="form-check form-switch ps-0">
                                <label class="form-check-label fw-semibold text-dark fs-6" for="status">Active Status</label>
                                <div class="text-secondary small mb-2">Toggle to enable/disable subcategory.</div>
                                <input class="form-check-input ms-0 border-secondary-subtle" style="width: 2.5em; height: 1.25em;" type="checkbox" id="status" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top border-light mt-5 pt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save Subcategory</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto Slug generator
    document.getElementById('name').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase()
            .trim()
            .replace(/[^\w\s\u0980-\u09FF-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection

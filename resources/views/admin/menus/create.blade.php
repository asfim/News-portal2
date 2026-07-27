@extends('layouts.admin')

@section('title', 'Add Menu Item')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Add Menu Item</h2>
            <p class="text-secondary mb-0">Create a new navigation link or dropdown header.</p>
        </div>
        <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
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
            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf
                
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label for="label" class="form-label fw-semibold text-secondary">Menu Item Label</label>
                            <input type="text" class="form-control py-3" id="label" name="label" value="{{ old('label') }}" placeholder="e.g. Home, Sports, Contact Us" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="value" class="form-label fw-semibold text-secondary">Target Value (Slug / URL)</label>
                            <input type="text" class="form-control py-3" id="value" name="value" value="{{ old('value') }}" placeholder="e.g. /category/sports, /contact" required>
                            <span class="small text-secondary">Relative paths (e.g., <code>/sports</code>) or full URLs are supported.</span>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-semibold text-secondary">Menu Type Node</label>
                                <select class="form-select py-3" id="type" name="type" required>
                                    <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>Custom Link</option>
                                    <option value="category" {{ old('type') == 'category' ? 'selected' : '' }}>Category Page</option>
                                    <option value="subcategory" {{ old('type') == 'subcategory' ? 'selected' : '' }}>Subcategory Page</option>
                                    <option value="page" {{ old('type') == 'page' ? 'selected' : '' }}>Static Page</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="sort_order" class="form-label fw-semibold text-secondary">Sorting Display Order</label>
                                <input type="number" class="form-control py-3" id="sort_order" name="sort_order" value="{{ old('sort_order', '0') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-light bg-opacity-25 border-0 p-4 rounded-3 mb-4">
                            <h5 class="fw-bold text-dark mb-4">Hierarchies & States</h5>

                            <div class="mb-4">
                                <label for="parent_id" class="form-label fw-semibold text-secondary">Parent Node</label>
                                <select class="form-select py-3" id="parent_id" name="parent_id">
                                    <option value="">No Parent (Root Link Node)</option>
                                    @foreach($parentMenus as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-check form-switch ps-0">
                                <label class="form-check-label fw-semibold text-dark fs-6" for="status">Active Link</label>
                                <div class="text-secondary small mb-2">Toggle to enable/disable navigation link.</div>
                                <input class="form-check-input ms-0 border-secondary-subtle" style="width: 2.5em; height: 1.25em;" type="checkbox" id="status" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top border-light mt-5 pt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save Menu Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

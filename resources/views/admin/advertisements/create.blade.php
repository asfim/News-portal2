@extends('layouts.admin')

@section('title', 'Add Advertisement')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Add Advertisement</h2>
            <p class="text-secondary mb-0">Create a new ad slot widget or banner campaign.</p>
        </div>
        <a href="{{ route('admin.advertisements.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
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
            <form action="{{ route('admin.advertisements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    <!-- General Details Column -->
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold text-secondary">Campaign Name / Title</label>
                            <input type="text" class="form-control py-3" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Header Leaderboard Google Ads" required autofocus>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="placement_key" class="form-label fw-semibold text-secondary">Placement Spot Key</label>
                                <select class="form-select py-3" id="placement_key" name="placement_key" required>
                                    <option value="header_banner" {{ old('placement_key') == 'header_banner' ? 'selected' : '' }}>Header Banner (728x90)</option>
                                    <option value="sidebar_top" {{ old('placement_key') == 'sidebar_top' ? 'selected' : '' }}>Sidebar Top (300x250)</option>
                                    <option value="sidebar_bottom" {{ old('placement_key') == 'sidebar_bottom' ? 'selected' : '' }}>Sidebar Bottom (300x600)</option>
                                    <option value="inside_content" {{ old('placement_key') == 'inside_content' ? 'selected' : '' }}>Inside Content (Fluid)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-semibold text-secondary">Advertisement Type</label>
                                <select class="form-select py-3" id="type" name="type" required>
                                    <option value="image" {{ old('type', 'image') == 'image' ? 'selected' : '' }}>Upload Image Banner</option>
                                    <option value="code" {{ old('type') == 'code' ? 'selected' : '' }}>Custom Script Code / AdSense</option>
                                </select>
                            </div>
                        </div>

                        <!-- Type 1: Image Banner fields -->
                        <div id="imageFields" class="mb-4">
                            <div class="mb-4">
                                <label for="image_upload" class="form-label fw-semibold text-secondary">Upload Banner Image</label>
                                <input type="file" class="form-control" id="image_upload" name="image_upload">
                                <span class="small text-secondary">Recommended: JPG, PNG or WebP. Max 2MB.</span>
                            </div>
                            <div class="mb-3">
                                <label for="redirect_url" class="form-label fw-semibold text-secondary">Redirect Destination URL</label>
                                <input type="url" class="form-control py-3" id="redirect_url" name="redirect_url" value="{{ old('redirect_url') }}" placeholder="https://advertiser-website.com">
                            </div>
                        </div>

                        <!-- Type 2: Custom Script fields -->
                        <div id="codeFields" class="mb-4 d-none">
                            <label for="script_code" class="form-label fw-semibold text-secondary">Custom Script/HTML Code</label>
                            <textarea class="form-control" id="script_code" name="script_code" rows="6" placeholder="Paste Google AdSense tag or HTML embed iframe scripts here...">{{ old('script_code') }}</textarea>
                        </div>
                    </div>

                    <!-- Sidebar Date Options Column -->
                    <div class="col-lg-4">
                        <div class="card bg-light bg-opacity-25 border-0 p-4 rounded-3 mb-4">
                            <h5 class="fw-bold text-dark mb-4">Campaign Lifespan</h5>

                            <div class="mb-4">
                                <label for="start_date" class="form-label fw-semibold text-secondary">Start Date</label>
                                <input type="date" class="form-control py-3" id="start_date" name="start_date" value="{{ old('start_date') }}">
                            </div>

                            <div class="mb-4">
                                <label for="end_date" class="form-label fw-semibold text-secondary">End Date</label>
                                <input type="date" class="form-control py-3" id="end_date" name="end_date" value="{{ old('end_date') }}">
                            </div>

                            <div class="form-check form-switch ps-0">
                                <label class="form-check-label fw-semibold text-dark fs-6" for="status">Active Status</label>
                                <div class="text-secondary small mb-2">Toggle to enable/disable advertisement.</div>
                                <input class="form-check-input ms-0 border-secondary-subtle" style="width: 2.5em; height: 1.25em;" type="checkbox" id="status" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top border-light mt-5 pt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save Campaign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const imageFields = document.getElementById('imageFields');
        const codeFields = document.getElementById('codeFields');

        typeSelect.addEventListener('change', function() {
            if (this.value === 'image') {
                imageFields.classList.remove('d-none');
                codeFields.classList.add('d-none');
            } else {
                imageFields.classList.add('d-none');
                codeFields.classList.remove('d-none');
            }
        });

        // Trigger change on load if value is old
        typeSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection

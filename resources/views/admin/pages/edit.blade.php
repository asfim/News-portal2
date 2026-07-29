@extends('layouts.admin')

@section('title', 'Edit Page')

@section('content')

<style>
.ck-editor__editable_inline {
    min-height: 400px;
}
</style>

<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Edit Static Page</h2>
            <p class="text-secondary mb-0">Modify static page configurations or content text.</p>
        </div>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
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

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Nav tabs -->
                <ul class="nav nav-pills mb-4 gap-2 bg-light p-2 rounded-3" id="pageTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active px-4 py-2.5 rounded-pill fw-semibold" id="content-tab" data-bs-toggle="tab" data-bs-target="#contentSec" type="button" role="tab" aria-controls="contentSec" aria-selected="true"><i class="fa-regular fa-file-lines me-1"></i> Content Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-2.5 rounded-pill fw-semibold" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seoSec" type="button" role="tab" aria-controls="seoSec" aria-selected="false"><i class="fa-solid fa-globe me-1"></i> SEO Meta</button>
                    </li>
                </ul>

                <div class="tab-content" id="pageTabsContent">
                    <!-- Content pane -->
                    <div class="tab-pane fade show active" id="contentSec" role="tabpanel" aria-labelledby="content-tab">
                        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold text-secondary">Page Title (Bengali) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control py-3" id="title" name="title" value="{{ old('title', $page->title) }}" placeholder="e.g. Terms of Service" required autofocus>
                            </div>

                            <div class="mb-4">
                                <label for="title_en" class="form-label fw-semibold text-secondary">Page Title (English)</label>
                                <input type="text" class="form-control py-3" id="title_en" name="title_en" value="{{ old('title_en', $page->title_en) }}" placeholder="e.g. Terms of Service">
                            </div>

                            <div class="mb-4">
                                <label for="slug" class="form-label fw-semibold text-secondary">Slug (SEO URL)</label>
                                <input type="text" class="form-control py-3" id="slug" name="slug" value="{{ old('slug', $page->slug) }}" placeholder="auto-generated-slug" required>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content (Bengali) <span class="text-danger">*</span></label>
                                <textarea class="form-control editor @error('content') is-invalid @enderror" id="content" name="content" rows="10">{{ old('content', $page->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content_en" class="form-label">Content (English)</label>
                                <textarea class="form-control editor @error('content_en') is-invalid @enderror" id="content_en" name="content_en" rows="10">{{ old('content_en', $page->content_en) }}</textarea>
                                @error('content_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    </div>

                    <!-- SEO pane -->
                    <div class="tab-pane fade" id="seoSec" role="tabpanel" aria-labelledby="seo-tab">
                        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                            <div class="mb-4">
                                <label for="meta_title" class="form-label fw-semibold text-secondary">Meta Title</label>
                                <input type="text" class="form-control py-3" id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" placeholder="Leave blank to use page title">
                            </div>

                            <div class="mb-4">
                                <label for="meta_description" class="form-label fw-semibold text-secondary">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Provide SEO description summary...">{{ old('meta_description', $page->meta_description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label fw-semibold text-secondary">Meta Keywords</label>
                                <input type="text" class="form-control py-3" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}" placeholder="e.g. privacy, policy, portal">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-light bg-opacity-25 border-0 p-4 rounded-3 mb-4">
                    <h5 class="fw-bold text-dark mb-4">Configurations</h5>

                    

                    <div class="form-check form-switch ps-0">
                        <label class="form-check-label fw-semibold text-dark fs-6" for="status">Active Page</label>
                        <div class="text-secondary small mb-2">Toggle to enable/disable static page visibility.</div>
                        <input class="form-check-input ms-0 border-secondary-subtle" style="width: 2.5em; height: 1.25em;" type="checkbox" id="status" name="status" value="1" {{ old('status', $page->status ? '1' : '0') == '1' ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save Changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Load CKEditor 5 from CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. CKEditor Initialization
        ClassicEditor
            .create(document.querySelector('#wysiwygEditor'), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
            })
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    document.getElementById('editorContent').value = editor.getData();
                });
                editor.setData(document.getElementById('editorContent').value);
            });

        // 2. Slug Auto Generation
        document.getElementById('title').addEventListener('input', function() {
            let title = this.value;
            let slug = title.toLowerCase()
                .trim()
                .replace(/[^\w\s\u0980-\u09FF-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        });
    });
</script>
@endsection

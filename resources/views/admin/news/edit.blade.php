@extends('layouts.admin')

@section('title', 'Edit Article')

@section('content')
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Edit Article</h2>
                <p class="text-secondary mb-0">Modify settings, tags, content or status workflow.</p>
            </div>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
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

        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills mb-4 gap-2 bg-light p-2 rounded-3" id="articleTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-4 py-2.5 rounded-pill fw-semibold" id="content-tab"
                                data-bs-toggle="tab" data-bs-target="#contentSec" type="button" role="tab"
                                aria-controls="contentSec" aria-selected="true"><i
                                    class="fa-regular fa-file-lines me-1"></i> Post Content</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-2.5 rounded-pill fw-semibold" id="media-tab"
                                data-bs-toggle="tab" data-bs-target="#mediaSec" type="button" role="tab"
                                aria-controls="mediaSec" aria-selected="false"><i class="fa-regular fa-image me-1"></i>
                                Media & Connections</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-2.5 rounded-pill fw-semibold" id="seo-tab"
                                data-bs-toggle="tab" data-bs-target="#seoSec" type="button" role="tab"
                                aria-controls="seoSec" aria-selected="false"><i class="fa-solid fa-globe me-1"></i> SEO
                                Meta</button>
                        </li>
                    </ul>

                    <!-- Tab contents -->
                    <div class="tab-content" id="articleTabsContent">
                        <!-- Section 1: Content -->
                        <div class="tab-pane fade show active" id="contentSec" role="tabpanel"
                            aria-labelledby="content-tab">
                            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-semibold text-secondary">Article
                                        Title</label>
                                    <input type="text" class="form-control py-3" id="title" name="title"
                                        value="{{ old('title', $news->title) }}" placeholder="Compose a catchy title..."
                                        required autofocus>
                                </div>

                                <div class="mb-4">
                                    <label for="slug" class="form-label fw-semibold text-secondary">Slug (SEO
                                        URL)</label>
                                    <input type="text" class="form-control py-3" id="slug" name="slug"
                                        value="{{ old('slug', $news->slug) }}" placeholder="auto-generated-slug" required>
                                </div>

                                <div class="mb-4">
                                    <label for="short_description" class="form-label fw-semibold text-secondary">Short
                                        Description / Sub-headline</label>
                                    <textarea class="form-control" id="short_description" name="short_description" rows="3"
                                        placeholder="Write a short summary that appears in lists..." required>{{ old('short_description', $news->short_description) }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="editorContent"
                                        class="form-label fw-semibold text-secondary d-flex justify-content-between align-items-center">
                                        Long Content
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary rounded-pill select-media-btn"
                                            data-target="ckeditor">
                                            <i class="fa-solid fa-photo-film me-1"></i> Insert Media
                                        </button>
                                    </label>
                                    <!-- Quill / CKEditor textarea -->
                                    <textarea class="form-control d-none" id="editorContent" name="content">{{ old('content', $news->content) }}</textarea>
                                    <div id="wysiwygEditor" style="min-height: 400px; border-radius: 0 0 12px 12px;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Media & Connections -->
                        <div class="tab-pane fade" id="mediaSec" role="tabpanel" aria-labelledby="media-tab">
                            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold text-dark mb-3">Featured Image</h6>
                                        <div class="bg-light p-3 rounded-3 text-center border">
                                            <input type="hidden" name="featured_image" id="featured_image_id"
                                                value="{{ old('featured_image', $news->featured_image) }}">

                                            <img id="featured_image_preview"
                                                src="{{ $news->featuredImage ? $news->featuredImage->path : '' }}"
                                                class="img-fluid rounded mb-3 {{ $news->featuredImage ? '' : 'd-none' }}"
                                                style="max-height: 150px; object-fit: contain;">

                                            <div id="featured_image_placeholder"
                                                class="text-secondary py-4 small {{ $news->featuredImage ? 'd-none' : '' }}">
                                                <i class="fa-regular fa-image display-6 mb-2 opacity-50"></i>
                                                <p class="mb-0">No image selected</p>
                                            </div>
                                            <button type="button"
                                                class="btn btn-outline-primary btn-sm px-4 rounded-pill fw-semibold select-media-btn"
                                                data-target="featured_image">Browse Library</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold text-dark mb-3">List Thumbnail</h6>
                                        <div class="bg-light p-3 rounded-3 text-center border">
                                            <input type="hidden" name="thumbnail" id="thumbnail_id"
                                                value="{{ old('thumbnail', $news->thumbnail) }}">

                                            <img id="thumbnail_preview"
                                                src="{{ $news->thumbnailImage ? $news->thumbnailImage->path : '' }}"
                                                class="img-fluid rounded mb-3 {{ $news->thumbnailImage ? '' : 'd-none' }}"
                                                style="max-height: 150px; object-fit: contain;">

                                            <div id="thumbnail_placeholder"
                                                class="text-secondary py-4 small {{ $news->thumbnailImage ? 'd-none' : '' }}">
                                                <i class="fa-regular fa-image display-6 mb-2 opacity-50"></i>
                                                <p class="mb-0">No image selected</p>
                                            </div>
                                            <button type="button"
                                                class="btn btn-outline-primary btn-sm px-4 rounded-pill fw-semibold select-media-btn"
                                                data-target="thumbnail">Browse Library</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="video_upload" class="form-label fw-semibold text-secondary">Upload Raw
                                        Video (Max 50MB)</label>
                                    @if ($news->video_url && str_starts_with($news->video_url, '/storage/news_videos'))
                                        <div class="mb-2">
                                            <video src="{{ asset($news->video_url) }}" controls class="w-100 rounded"
                                                style="max-height: 250px;"></video>
                                        </div>
                                        <small class="d-block text-muted mb-2">Upload a new file to replace the existing
                                            video.</small>
                                    @endif
                                    <input type="file" class="form-control" id="video_upload" name="video_upload"
                                        accept="video/mp4,video/webm,video/ogg">
                                    <div class="form-text mt-2 text-muted">OR Provide a YouTube / External Video URL below:
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="video_url" class="form-label fw-semibold text-secondary">YouTube /
                                        External Video URL</label>
                                    <input type="url" class="form-control py-3" id="video_url" name="video_url"
                                        value="{{ old('video_url', str_starts_with($news->video_url ?? '', '/storage/news_videos') ? '' : $news->video_url) }}"
                                        placeholder="https://youtube.com/watch?v=...">
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="source_name" class="form-label fw-semibold text-secondary">Source
                                            Agency Name</label>
                                        <input type="text" class="form-control py-3" id="source_name"
                                            name="source_name" value="{{ old('source_name', $news->source_name) }}"
                                            placeholder="e.g. Reuters, AFP">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="source_url" class="form-label fw-semibold text-secondary">Source
                                            Article URL</label>
                                        <input type="url" class="form-control py-3" id="source_url"
                                            name="source_url" value="{{ old('source_url', $news->source_url) }}"
                                            placeholder="https://source-agency.com/article">
                                    </div>
                                </div>

                                <!-- Tags selection list -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Tags</label>
                                    <div class="d-flex flex-wrap gap-2 p-3 bg-light rounded-3 border">
                                        @php
                                            $newsTags = $news->tags->pluck('id')->toArray();
                                        @endphp
                                        @foreach ($tags as $tag)
                                            <div
                                                class="form-check form-check-inline border bg-white px-3 py-1.5 rounded-pill mb-0 d-flex align-items-center">
                                                <input class="form-check-input mt-0 me-2" type="checkbox" name="tags[]"
                                                    id="tag_{{ $tag->id }}" value="{{ $tag->id }}"
                                                    {{ in_array($tag->id, old('tags', $newsTags)) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark small cursor-pointer"
                                                    for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: SEO Meta -->
                        <div class="tab-pane fade" id="seoSec" role="tabpanel" aria-labelledby="seo-tab">
                            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                                <div class="mb-4">
                                    <label for="meta_title" class="form-label fw-semibold text-secondary">Meta
                                        Title</label>
                                    <input type="text" class="form-control py-3" id="meta_title" name="meta_title"
                                        value="{{ old('meta_title', $news->meta_title) }}"
                                        placeholder="Leave blank to use article title">
                                </div>

                                <div class="mb-4">
                                    <label for="meta_description" class="form-label fw-semibold text-secondary">Meta
                                        Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                                        placeholder="Provide SEO description summary...">{{ old('meta_description', $news->meta_description) }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="meta_keywords" class="form-label fw-semibold text-secondary">Meta
                                        Keywords</label>
                                    <input type="text" class="form-control py-3" id="meta_keywords"
                                        name="meta_keywords" value="{{ old('meta_keywords', $news->meta_keywords) }}"
                                        placeholder="e.g. politics, news, breaking">
                                </div>

                                <div class="mb-3">
                                    <label for="canonical_url" class="form-label fw-semibold text-secondary">Canonical
                                        URL</label>
                                    <input type="url" class="form-control py-3" id="canonical_url"
                                        name="canonical_url" value="{{ old('canonical_url', $news->canonical_url) }}"
                                        placeholder="https://canonical-url.com">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Controls -->
                <div class="col-lg-4">
                    <div class="card bg-light bg-opacity-25 border-0 p-4 rounded-3 mb-4">
                        <h5 class="fw-bold text-dark mb-4">Publishing Info</h5>

                        <div class="mb-4">
                            <label for="category_id" class="form-label fw-semibold text-secondary">Primary
                                Category</label>
                            <select class="form-select py-3" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $news->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="subcategory_id" class="form-label fw-semibold text-secondary">Subcategory
                                (Optional)</label>
                            <select class="form-select py-3" id="subcategory_id" name="subcategory_id">
                                <option value="">Select Subcategory</option>
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ old('subcategory_id', $news->subcategory_id) == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="author_id" class="form-label fw-semibold text-secondary">Author Profile</label>
                            <select class="form-select py-3" id="author_id" name="author_id" required>
                                <option value="">Select Author</option>
                                @foreach ($authors as $auth)
                                    <option value="{{ $auth->id }}"
                                        {{ old('author_id', $news->author_id) == $auth->id ? 'selected' : '' }}>
                                        {{ $auth->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold text-secondary">Workflow Status</label>
                            <select class="form-select py-3" id="status" name="status" required>
                                <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>
                                    Draft</option>
                                <option value="pending" {{ old('status', $news->status) == 'pending' ? 'selected' : '' }}>
                                    Pending Moderation</option>
                                <option value="published"
                                    {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>Publish Immediately
                                </option>
                                <option value="scheduled"
                                    {{ old('status', $news->status) == 'scheduled' ? 'selected' : '' }}>Schedule
                                    Publication</option>
                            </select>
                        </div>

                        <div class="mb-4 {{ old('status', $news->status) == 'scheduled' ? '' : 'd-none' }}"
                            id="scheduleTimeSec">
                            <label for="publish_at" class="form-label fw-semibold text-secondary">Publication Date &
                                Time</label>
                            <input type="datetime-local" class="form-control py-3" id="publish_at" name="publish_at"
                                value="{{ old('publish_at', $news->publish_at ? $news->publish_at->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        <div class="border-top pt-4">
                            <h6 class="fw-bold text-dark mb-3">Feature Flags</h6>

                            <div class="form-check form-switch ps-0 mb-3">
                                <label class="form-check-label fw-semibold text-dark small" for="breaking_news">Breaking
                                    News Alert</label>
                                <input class="form-check-input ms-0 border-secondary-subtle float-end"
                                    style="width: 2.2em; height: 1.1em;" type="checkbox" id="breaking_news"
                                    name="breaking_news" value="1"
                                    {{ old('breaking_news', $news->breaking_news) ? 'checked' : '' }}>
                            </div>

                            <div class="form-check form-switch ps-0 mb-3">
                                <label class="form-check-label fw-semibold text-dark small" for="featured_news">Homepage
                                    Featured Block</label>
                                <input class="form-check-input ms-0 border-secondary-subtle float-end"
                                    style="width: 2.2em; height: 1.1em;" type="checkbox" id="featured_news"
                                    name="featured_news" value="1"
                                    {{ old('featured_news', $news->featured_news) ? 'checked' : '' }}>
                            </div>

                            <div class="form-check form-switch ps-0 mb-3">
                                <label class="form-check-label fw-semibold text-dark small" for="trending_news">Trending
                                    Article</label>
                                <input class="form-check-input ms-0 border-secondary-subtle float-end"
                                    style="width: 2.2em; height: 1.1em;" type="checkbox" id="trending_news"
                                    name="trending_news" value="1"
                                    {{ old('trending_news', $news->trending_news) ? 'checked' : '' }}>
                            </div>

                            <div class="form-check form-switch ps-0 mb-3">
                                <label class="form-check-label fw-semibold text-dark small" for="editor_choice">Editor's
                                    Pick</label>
                                <input class="form-check-input ms-0 border-secondary-subtle float-end"
                                    style="width: 2.2em; height: 1.1em;" type="checkbox" id="editor_choice"
                                    name="editor_choice" value="1"
                                    {{ old('editor_choice', $news->editor_choice) ? 'checked' : '' }}>
                            </div>

                            <div class="form-check form-switch ps-0 mb-3">
                                <label class="form-check-label fw-bold text-danger small" for="is_latest">Latest News (Max
                                    9)</label>
                                <input class="form-check-input ms-0 border-danger float-end"
                                    style="width: 2.2em; height: 1.1em;" type="checkbox" id="is_latest" name="is_latest"
                                    value="1" {{ old('is_latest', $news->is_latest) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-semibold shadow-sm"><i
                                class="fa-solid fa-circle-check me-2"></i> Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Reusable Media Library Modal -->
    <div class="modal fade" id="mediaSelectModal" tabindex="-1" aria-labelledby="mediaSelectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header px-4 py-3 bg-light">
                    <h5 class="modal-title fw-bold text-dark" id="mediaSelectModalLabel"><i
                            class="fa-regular fa-images me-1"></i> Select Image from Library</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="input-group mb-4 shadow-sm border rounded-pill overflow-hidden">
                        <span class="input-group-text bg-white border-0 text-secondary ps-3"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control border-0 py-2.5" id="modalSearchInput"
                            placeholder="Filter media by title/caption...">
                    </div>

                    <div class="row g-3" id="modalMediaGrid">
                        <!-- Dynamic Grid -->
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light text-end">
                    <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold"
                        id="btnConfirmMediaSelect">Select Image</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Load CKEditor 5 from CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let ckEditorInstance;
            // 1. CKEditor Initialization
            ClassicEditor
                .create(document.querySelector('#wysiwygEditor'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        'blockQuote', 'insertTable', 'undo', 'redo'
                    ]
                })
                .then(editor => {
                    ckEditorInstance = editor;
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
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                document.getElementById('slug').value = slug;
            });

            // 3. Category change reloads subcategories
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('subcategory_id');

            categorySelect.addEventListener('change', function() {
                const catId = this.value;
                subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                if (!catId) return;

                fetch(`/admin/categories/${catId}/subcategories`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.name;
                            subcategorySelect.appendChild(option);
                        });
                    });
            });

            // 4. Scheduling Visibility Switcher
            const statusSelect = document.getElementById('status');
            const scheduleTimeSec = document.getElementById('scheduleTimeSec');

            statusSelect.addEventListener('change', function() {
                if (this.value === 'scheduled') {
                    scheduleTimeSec.classList.remove('d-none');
                    document.getElementById('publish_at').required = true;
                } else {
                    scheduleTimeSec.classList.add('d-none');
                    document.getElementById('publish_at').required = false;
                }
            });

            // 5. Reusable Media Selector logic
            let mediaTarget = '';
            const selectMediaModal = new bootstrap.Modal(document.getElementById('mediaSelectModal'));
            const modalMediaGrid = document.getElementById('modalMediaGrid');
            const modalSearchInput = document.getElementById('modalSearchInput');
            let selectedMediaId = null;
            let selectedMediaPath = null;

            document.querySelectorAll('.select-media-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    mediaTarget = this.getAttribute('data-target');
                    loadModalMedia();
                    selectMediaModal.show();
                });
            });

            function loadModalMedia() {
                const search = modalSearchInput.value;
                fetch(`/admin/media?search=${encodeURIComponent(search)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        modalMediaGrid.innerHTML = data.html;
                        bindModalItemsSelection();
                    });
            }

            modalSearchInput.addEventListener('input', loadModalMedia);

            function bindModalItemsSelection() {
                modalMediaGrid.querySelectorAll('.media-card').forEach(card => {
                    card.addEventListener('click', function() {
                        modalMediaGrid.querySelectorAll('.media-card').forEach(c => c.classList
                            .remove('selected'));
                        this.classList.add('selected');
                        selectedMediaId = this.getAttribute('data-id');
                        selectedMediaPath = this.getAttribute('data-path');
                    });
                });
            }

            document.getElementById('btnConfirmMediaSelect').addEventListener('click', function() {
                if (!selectedMediaId) return;

                if (mediaTarget === 'ckeditor') {
                    ckEditorInstance.model.change(writer => {
                        const imageElement = writer.createElement('imageBlock', {
                            src: selectedMediaPath
                        });
                        ckEditorInstance.model.insertContent(imageElement, ckEditorInstance.model
                            .document.selection);
                    });
                    selectMediaModal.hide();
                    return;
                }

                document.getElementById(mediaTarget + '_id').value = selectedMediaId;
                const preview = document.getElementById(mediaTarget + '_preview');
                preview.src = selectedMediaPath;
                preview.classList.remove('d-none');

                document.getElementById(mediaTarget + '_placeholder').classList.add('d-none');
                selectMediaModal.hide();
            });
        });
    </script>
@endsection

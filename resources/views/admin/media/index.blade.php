@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Media Library</h2>
            <p class="text-secondary mb-0">Upload, optimize, and organize visual assets for articles.</p>
        </div>
    </div>

    <!-- Upload Panel -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4 text-center border-dashed rounded-3 bg-light bg-opacity-25" id="uploadArea">
            <i class="fa-solid fa-cloud-arrow-up display-5 text-secondary mb-3"></i>
            <h5 class="fw-bold text-dark mb-1">Drag & Drop Files Here</h5>
            <p class="text-secondary small">Supports Images (Max 10MB) & Videos (Max 50MB)</p>
            
            <input type="file" id="fileSelector" class="d-none" multiple accept="image/*,video/*">
            <button type="button" class="btn btn-outline-primary btn-sm px-4 rounded-pill fw-semibold mt-2" onclick="document.getElementById('fileSelector').click()">Select Files</button>
            
            <div id="uploadProgress" class="progress mt-3 d-none" style="height: 10px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Search & Grid Wrapper -->
    <div class="row g-4">
        <!-- Media Grid Column -->
        <div class="col-lg-9 col-md-8">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-3">
                    <form id="mediaSearchForm" class="row g-3 align-items-center">
                        <div class="col-12">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" class="form-control bg-light border-0" id="mediaSearchInput" placeholder="Search images by name, alt text or caption...">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Grid Render Area -->
            <div id="mediaGrid">
                @include('admin.media.partials.grid')
            </div>
            <div id="mediaPagination">
                @include('admin.media.partials.pagination')
            </div>
        </div>

        <!-- Sidebar Metadata Editor Drawer -->
        <div class="col-lg-3 col-md-4">
            <div class="card border-0 shadow-sm rounded-3 sticky-md-top" style="top: 90px; z-index: 1;">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="fw-bold text-dark mb-0">Asset Details</h5>
                </div>
                <div class="card-body p-4" id="detailsPanel">
                    <div class="text-center py-5 text-secondary" id="noSelectionMsg">
                        <i class="fa-regular fa-hand-pointer fs-2 mb-3"></i>
                        <p class="small mb-0">Select an image from the grid to view properties and edit details.</p>
                    </div>

                    <div class="d-none" id="detailsFormWrapper">
                        <div class="mb-3 text-center border p-2 rounded bg-light" id="previewWrapper">
                            <img src="" alt="Preview" id="previewImg" class="img-fluid rounded d-none" style="max-height: 150px; object-fit: contain;">
                            <video src="" id="previewVideo" class="img-fluid rounded d-none" style="max-height: 150px; object-fit: contain;" controls></video>
                        </div>

                        <form id="mediaDetailsForm">
                            @csrf
                            <input type="hidden" id="editMediaId">
                            
                            <div class="mb-3">
                                <label for="editName" class="form-label text-secondary small fw-semibold">File Title</label>
                                <input type="text" class="form-control py-2" id="editName" required>
                            </div>

                            <div class="mb-3">
                                <label for="editAlt" class="form-label text-secondary small fw-semibold">Alt Text</label>
                                <input type="text" class="form-control py-2" id="editAlt">
                            </div>

                            <div class="mb-3">
                                <label for="editCaption" class="form-label text-secondary small fw-semibold">Caption</label>
                                <textarea class="form-control" id="editCaption" rows="2"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="editCopyright" class="form-label text-secondary small fw-semibold">Copyright / Source</label>
                                <input type="text" class="form-control py-2" id="editCopyright">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold small" id="btnUpdateMedia">Save Changes</button>
                                <button type="button" class="btn btn-outline-danger py-2 px-3 rounded-circle" id="btnDeleteMedia"><i class="fa-regular fa-trash-can"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-dashed {
        border: 2px dashed #cbd5e1;
        transition: all 0.25s ease;
    }
    .border-dashed:hover, .border-dashed.dragover {
        border-color: #3b82f6;
        background-color: rgba(59, 130, 246, 0.03) !important;
    }
</style>

<script>
    // AJAX media handling scripts
    document.addEventListener('DOMContentLoaded', function() {
        const fileSelector = document.getElementById('fileSelector');
        const uploadArea = document.getElementById('uploadArea');
        const searchInput = document.getElementById('mediaSearchInput');
        const detailsPanel = document.getElementById('detailsPanel');
        
        // Dynamic load handler
        function loadMedia(url = '/admin/media') {
            const query = searchInput.value;
            fetch(url + (url.includes('?') ? '&' : '?') + 'search=' + encodeURIComponent(query), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('mediaGrid').innerHTML = data.html;
                document.getElementById('mediaPagination').innerHTML = data.pagination;
                bindCardSelection();
            });
        }

        // 1. Drag & Drop Uploads
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            uploadFiles(e.dataTransfer.files);
        });
        fileSelector.addEventListener('change', () => {
            uploadFiles(fileSelector.files);
        });

        function uploadFiles(files) {
            if(files.length === 0) return;
            const formData = new FormData();
            for(let i=0; i<files.length; i++) {
                formData.append('files[]', files[i]);
            }
            formData.append('_token', '{{ csrf_token() }}');

            const progressBar = document.querySelector('#uploadProgress');
            const bar = progressBar.querySelector('.progress-bar');
            progressBar.classList.remove('d-none');
            bar.style.width = '0%';

            fetch('{{ route("admin.media.store") }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(async res => {
                if (!res.ok) {
                    const errData = await res.json().catch(() => ({}));
                    throw errData;
                }
                return res.json();
            })
            .then(data => {
                progressBar.classList.add('d-none');
                if(data.success) {
                    loadMedia();
                }
            })
            .catch(err => {
                progressBar.classList.add('d-none');
                let errMsg = 'Upload failed! Images (Max 10MB) & Videos (Max 50MB) allowed.';
                if (err.errors) {
                    errMsg = Object.values(err.errors).flat().join('\n');
                } else if (err.message) {
                    errMsg = err.message;
                }
                alert(errMsg);
            });
        }

        // 2. Search filtering
        searchInput.addEventListener('input', () => {
            loadMedia();
        });

        // 3. Selection details pane binder
        function bindCardSelection() {
            document.querySelectorAll('.media-card').forEach(card => {
                card.addEventListener('click', function() {
                    document.querySelectorAll('.media-card').forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');

                    document.getElementById('noSelectionMsg').classList.add('d-none');
                    document.getElementById('detailsFormWrapper').classList.remove('d-none');

                    const mime = this.getAttribute('data-mime');
                    const path = this.getAttribute('data-path');
                    
                    if(mime.startsWith('video/')) {
                        document.getElementById('previewImg').classList.add('d-none');
                        const vid = document.getElementById('previewVideo');
                        vid.classList.remove('d-none');
                        vid.src = path;
                    } else {
                        document.getElementById('previewVideo').classList.add('d-none');
                        const img = document.getElementById('previewImg');
                        img.classList.remove('d-none');
                        img.src = path;
                    }

                    document.getElementById('editMediaId').value = this.getAttribute('data-id');
                    document.getElementById('editName').value = this.getAttribute('data-name');
                    document.getElementById('editAlt').value = this.getAttribute('data-alt');
                    document.getElementById('editCaption').value = this.getAttribute('data-caption');
                    document.getElementById('editCopyright').value = this.getAttribute('data-copyright');
                });
            });
        }
        bindCardSelection();

        // 4. Update details request
        document.getElementById('btnUpdateMedia').addEventListener('click', function() {
            const id = document.getElementById('editMediaId').value;
            const payload = {
                _token: '{{ csrf_token() }}',
                _method: 'PUT',
                name: document.getElementById('editName').value,
                alt_text: document.getElementById('editAlt').value,
                caption: document.getElementById('editCaption').value,
                copyright: document.getElementById('editCopyright').value,
            };

            fetch(`/admin/media/${id}`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    loadMedia();
                }
            });
        });

        // 5. Delete asset request
        document.getElementById('btnDeleteMedia').addEventListener('click', function() {
            if(!confirm('Are you sure you want to permanently delete this image from server?')) return;
            const id = document.getElementById('editMediaId').value;
            
            fetch(`/admin/media/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    '_method': 'DELETE',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ _method: 'DELETE', _token: '{{ csrf_token() }}' })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('noSelectionMsg').classList.remove('d-none');
                    document.getElementById('detailsFormWrapper').classList.add('d-none');
                    loadMedia();
                }
            });
        });

        // 6. Pagination interception
        document.addEventListener('click', function(e) {
            const link = e.target.closest('#mediaPagination a');
            if(link) {
                e.preventDefault();
                loadMedia(link.href);
            }
        });
    });
</script>
@endsection

<div class="row g-3">
    @if($media->isEmpty())
        <div class="col-12 text-center py-5 text-secondary">
            <i class="fa-regular fa-image fs-1 opacity-50 mb-3"></i>
            <p>No media files found. Upload some assets to get started.</p>
        </div>
    @else
        @foreach($media as $item)
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <div class="card h-100 border-0 shadow-sm rounded-3 media-card cursor-pointer" 
                     data-id="{{ $item->id }}" 
                     data-name="{{ $item->name }}"
                     data-path="{{ $item->path }}" 
                     data-alt="{{ $item->alt_text }}"
                     data-caption="{{ $item->caption }}" 
                     data-copyright="{{ $item->copyright }}"
                     data-size="{{ number_format($item->size / 1024, 2) }} KB"
                     data-mime="{{ $item->mime_type }}">
                    
                    <div class="position-relative ratio ratio-1x1 overflow-hidden rounded-top-3 bg-dark d-flex align-items-center justify-content-center">
                        @if(str_starts_with($item->mime_type, 'video/'))
                            <video src="{{ $item->path }}" class="img-fluid object-fit-cover w-100 h-100" muted preload="metadata"></video>
                            <i class="fa-solid fa-circle-play text-white position-absolute fs-3" style="opacity:0.8;"></i>
                        @else
                            <img src="{{ $item->path }}" alt="{{ $item->alt_text }}" class="img-fluid object-fit-cover w-100 h-100">
                        @endif
                    </div>
                    <div class="card-body p-2 text-center">
                        <div class="text-truncate small fw-semibold text-dark">{{ $item->name }}</div>
                        <span class="small text-secondary" style="font-size: 0.75rem;">{{ number_format($item->size / 1024, 2) }} KB</span>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<style>
    .media-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .media-card:hover, .media-card.selected {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
    }
    .media-card.selected {
        outline: 3px solid #3b82f6;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>

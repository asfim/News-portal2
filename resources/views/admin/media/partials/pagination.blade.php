@if($media->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $media->links() }}
    </div>
@endif

@if($ad->type === 'image')
    @if($ad->redirect_url)
        <a href="{{ $ad->redirect_url }}" target="_blank" rel="noopener nofollow" class="d-block w-100 text-center {{ $class }}">
            <img src="{{ asset($ad->image_path) }}" alt="{{ $ad->title }}" class="img-fluid" style="max-height: 100%; width: auto;">
        </a>
    @else
        <div class="d-block w-100 text-center {{ $class }}">
            <img src="{{ asset($ad->image_path) }}" alt="{{ $ad->title }}" class="img-fluid" style="max-height: 100%; width: auto;">
        </div>
    @endif
@elseif($ad->type === 'code')
    <div class="w-100 text-center overflow-hidden {{ $class }}">
        {!! $ad->script_code !!}
    </div>
@endif
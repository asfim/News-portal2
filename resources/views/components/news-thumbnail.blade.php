@if ($type === 'video')
    <video src="{{ $url }}" class="{{ $classes }}" muted preload="metadata" onmouseover="this.play()"
        onmouseout="this.pause(); this.currentTime=0.5;"></video>
@else
    <img src="{{ $url }}" class="{{ $classes }}" alt="{{ $alt }}">
@endif

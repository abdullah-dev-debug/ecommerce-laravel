<div class="empty-state-container text-center py-5">
    <i class="fa {{ $icon ?? 'fa-info-circle' }} fa-3x text-muted mb-3"></i>

    <h4 class="mb-2">{{ $title ?? 'Nothing here' }}</h4>

    <p class="mb-4 text-muted">{{ $subtitle ?? 'No data available at the moment.' }}</p>

    @if(isset($buttonText) && isset($buttonLink))
    <a href="{{ $buttonLink }}" class="btn btn-primary">{{ $buttonText }}</a>
    @endif
</div>
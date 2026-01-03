@if(isset($ads) && count($ads) > 0)
@foreach ($ads as $banner)
    <div class="home-page-ads-item">
        <img src={{ $banner->path ?? $banner['path'] }} alt="Ads"
            width="467" height="207">
        <div class="home-page-ads-item-content-wrap {{ $banner->class ?? $banner['class']  }}">
            <h3>{{ $banner->title ?? $banner['title'] }}</h3>
            <a href="{{ $banner->link ?? $banner['link'] }}" class="{{ $banner->class ?? $banner['class'] }}">Shop Now</a>
        </div>
    </div>
@endforeach
@endif
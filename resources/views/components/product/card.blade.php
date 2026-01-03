@php
if (!$product) return;
$activeImage = $product->gallery[0] ?? null;
$variants = $product->variants ?? null;
$colors = $variants->pluck('color')->unique();
@endphp

<div class="product-card-item">
    <div class="product-card-item-header">
        <img src="{{ asset($product->thumbnail ?? '') }}"
            alt="{{ $product->title ?? 'Product Thumbnail' }}" width="245" height="245" class="default-product-image">
        <img src="{{ asset($activeImage->path ?? '') }}" alt="{{ $product->title ?? 'Product Gallery' }}"
            width="245" height="245" class="active-product-image">
        <div class="product-card-widget-wrap">
            <div class="product-card-features-list">
                <a href="javascript:void(0)" class="product-card-feature-btn" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="Add to Wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M462.3 62.7c-54.5-46.4-136-38.7-186.6 13.5L256 96.6l-19.7-20.3C195.5 34.1 113.2 8.7 49.7 62.7c-62.8 53.6-66.1 149.8-9.9 207.8l193.5 199.8c6.2 6.4 14.4 9.7 22.6 9.7 8.2 0 16.4-3.2 22.6-9.7L472 270.5c56.4-58 53.1-154.2-9.7-207.8zm-13.1 185.6L256.4 448.1 62.8 248.3c-38.4-39.6-46.4-115.1 7.7-161.2 54.8-46.8 119.2-12.9 142.8 11.5l42.7 44.1 42.7-44.1c23.2-24 88.2-58 142.8-11.5 54 46 46.1 121.5 7.7 161.2z">
                        </path>
                    </svg>
                </a>

                <a href="javascript:void(0)" class="product-card-feature-btn" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="Compare Product">
                    <span title="Add To Compare" class="add__wishlist">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-switch" width="44"
                            height="44" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <polyline points="15 4 19 4 19 8"></polyline>
                            <line x1="14.75" y1="9.25" x2="19" y2="4"></line>
                            <line x1="5" y1="19" x2="9" y2="15"></line>
                            <polyline points="15 19 19 19 19 15"></polyline>
                            <line x1="5" y1="5" x2="19" y2="19"></line>
                        </svg>
                    </span>
                </a>

                <a href="javascript:void(0)" class="product-card-feature-btn" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="Quick View">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-eye">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </a>
            </div>
            <a href="javascript:void(0)" class="bs-btn bs-btn-primary w-100 quick-shop-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <rect width="24" height="24" fill="none" />
                    <path fill="currentColor"
                        d="M17 18a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2c0-1.11.89-2 2-2M1 2h3.27l.94 2H20a1 1 0 0 1 1 1c0 .17-.05.34-.12.5l-3.58 6.47c-.34.61-1 1.03-1.75 1.03H8.1l-.9 1.63l-.03.12a.25.25 0 0 0 .25.25H19v2H7a2 2 0 0 1-2-2c0-.35.09-.68.24-.96l1.36-2.45L3 4H1zm6 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2c0-1.11.89-2 2-2m9-7l2.78-5H6.14l2.36 5z" />
                </svg>
                Quick Shop
            </a>
        </div>
    </div>
    <div class="product-card-item-content">
        <h4>{{ $product->title ?? '' }}</h4>
        <div class="product-card-price-wrap">
            <span class="product-card-discount-price"> $ {{ $product->discount_price ?? '' }} </span>
            <span class="product-card-price">$ {{ $product->cost_price ?? '' }} </span>
        </div>
        <div class="product-card-colors-wrap">
            @foreach ($colors as $color)
            <span class="product-card-color-item" style="background-color: {{ $color->code ?? '#000000' }};"></span>
            @endforeach
            @if ($colors->count() > 3)
            <a href="javascript:void(0)" class="product-card-additional-color">+{{ $colors->count() - 3 }}</a>
            @endif
        </div>
        <div class="product-card-reviews-wrap">
            @for ($i = 0; $i < 5; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                <rect width="24" height="24" fill="none" />
                <path fill="currentColor"
                    d="m7.325 18.923l1.24-5.313l-4.123-3.572l5.431-.47L12 4.557l2.127 5.01l5.43.47l-4.123 3.572l1.241 5.313L12 16.102z" />
                </svg>
                @endfor
                <span>0 Review</span>
        </div>
        <div class="product-card-stock">
            @if ($product->quantity > 0)
            <div class="in-stock featured-stock-item">
                <div class="product-card-stock-dot product-card-in-stock"></div> In stock {{ $product->quantity ?? 0 }} Items
            </div>
            @else
            <div class="out-of-stock featured-stock-item">
                <div class="product-card-stock-dot product-card-out-of-stock"></div> Out Of Stock
            </div>
            @endif
        </div>

        <!-- Responsive Features Buttons -->
        <div class="product-card-responsive-features-btn">
            <a href="javascript:void(0)" class="product-card-feature-btn" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-title="Add to Wishlist">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M462.3 62.7c-54.5-46.4-136-38.7-186.6 13.5L256 96.6l-19.7-20.3C195.5 34.1 113.2 8.7 49.7 62.7c-62.8 53.6-66.1 149.8-9.9 207.8l193.5 199.8c6.2 6.4 14.4 9.7 22.6 9.7 8.2 0 16.4-3.2 22.6-9.7L472 270.5c56.4-58 53.1-154.2-9.7-207.8zm-13.1 185.6L256.4 448.1 62.8 248.3c-38.4-39.6-46.4-115.1 7.7-161.2 54.8-46.8 119.2-12.9 142.8 11.5l42.7 44.1 42.7-44.1c23.2-24 88.2-58 142.8-11.5 54 46 46.1 121.5 7.7 161.2z">
                    </path>
                </svg>
            </a>

            <a href="javascript:void(0)" class="product-card-feature-btn" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-title="Compare Product">
                <span title="Add To Compare" class="add__wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-switch" width="44"
                        height="44" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <polyline points="15 4 19 4 19 8"></polyline>
                        <line x1="14.75" y1="9.25" x2="19" y2="4"></line>
                        <line x1="5" y1="19" x2="9" y2="15"></line>
                        <polyline points="15 19 19 19 19 15"></polyline>
                        <line x1="5" y1="5" x2="19" y2="19"></line>
                    </svg>
                </span>
            </a>

            <a href="javascript:void(0)" class="product-card-feature-btn" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-title="Quick View">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-eye">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            </a>
        </div>
    </div>
</div>
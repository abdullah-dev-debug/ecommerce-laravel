<section class="hero-section">
    <div class="main-container">
        <div class="hero-sec-items-wrap">
            <div class="hero-sec-slider-wrap">
                <div class="swiper hero-sec-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="https://isotech-demo.myshopify.com/cdn/shop/files/2_f639d039-1b63-405c-ab7d-4561d7871d76.png?v=1696134235"
                                width="750" height="480" alt="Slide 1">
                            <div class="hero-slide-content-wrap">
                                <div class="hero-side-inner-content">
                                    <h3>Galaxy Folding Phones</h3>
                                    <p>Which can vary depending on the brand and model electronic device.</p>
                                    <a href="javascript:void(0)" class="bs-btn hero-sec-cta-btn">Shop Now
                                        <iconify-icon icon="solar:alt-arrow-right-line-duotone"></iconify-icon></a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://isotech-demo.myshopify.com/cdn/shop/files/2_ae5cc69e-78af-4aea-9cc7-bb616d558539.png?v=1695797615"
                                width="750" height="480" alt="Slide 1">
                            <div class="hero-slide-content-wrap">
                                <div class="hero-side-inner-content">
                                    <h3>Galaxy Folding Phones</h3>
                                    <p>Which can vary depending on the brand and model electronic device.</p>
                                    <a href="javascript:void(0)" class="bs-btn hero-sec-cta-btn">Shop Now
                                        <iconify-icon icon="solar:alt-arrow-right-line-duotone"></iconify-icon></a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://isotech-demo.myshopify.com/cdn/shop/files/1_1cae1484-6708-4556-af27-18db5a0b650c.png?v=1696134352"
                                width="750" height="480" alt="Slide 1">
                            <div class="hero-slide-content-wrap">
                                <div class="hero-side-inner-content">
                                    <h3>Galaxy Folding Phones</h3>
                                    <p>Which can vary depending on the brand and model electronic device.</p>
                                    <a href="javascript:void(0)" class="bs-btn  hero-sec-cta-btn">Shop Now
                                        <iconify-icon icon="solar:alt-arrow-right-line-duotone"></iconify-icon></a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="swiper-pagination hero-sec-slider-pagination"></div>
                </div>
            </div>
            <div class="hero-sec-banners-wrap">
                <div class="banner-item-wrap">
                    <img src="https://isotech-demo.myshopify.com/cdn/shop/files/Frame_14.png?v=1695797658&width=1500"
                        alt="Banner 4">
                    <div class="hero-banner-content-wrap">
                        <h5>Special Discount</h5>
                        <h4>UP TO 50% OFF</h4>
                        <a href="/">Shop Now</a>
                    </div>
                </div>
                <div class="banner-item-wrap">
                    <img src="https://isotech-demo.myshopify.com/cdn/shop/files/Frame_15.png?v=1695797682&width=1500"
                        alt="Banner 5">
                    <div class="hero-banner-content-wrap">
                        <h5>Special Discount</h5>
                        <h4>UP TO 50% OFF</h4>
                        <a href="/">Shop Now</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>

@php
    $bannerData = [
        [
            'path' => 'https://isotech-demo.myshopify.com/cdn/shop/files/3_Banner_4.png?v=1695813715&width=710',
            'title' => 'Home Pade Speaker',
            'link' => '/',
            'class' => ''
        ],
        [
            'path' => 'https://isotech-demo.myshopify.com/cdn/shop/files/3_Banner_5.png?v=1695813736&width=710',
            'title' => 'Apple iPad',
            'link' => '/',
            'class' => 'text-black'
        ],
        [
            'path' => 'https://isotech-demo.myshopify.com/cdn/shop/files/3_Banner_6.png?v=1695813811&width=710',
            'title' => 'Hero Camera',
            'link' => '/',
            'class' => ''
        ]
    ];
@endphp

<section class="home-page-ads-section">
    <div class="main-container">
        <div class="home-page-ads-items-wrap">
            <x-ads :ads="$bannerData" />
        </div>
    </div>
</section>
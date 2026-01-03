<section class="deals-product-section">

    <div class="deals-product-sec-header">
        <h2>Best Deals Product</h2>
        <div class="deal-items-wrap">
            <span class="deal-label">Hurry up! Offer ends in:</span>
            <div class="deal-timer-wrap">
                <span class="deal-timer deal-time-hour">3</span>
                <span class="deal-timer deal-time-minutes">55</span>
                <span class="deal-timer deal-time-second">22</span>
            </div>
        </div>
    </div>
    <div class="deals-product-sec-body">
        <div class="deal-product-banner">
            <div class="deal-product-overlay"></div>
            <img src="https://isotech-demo.myshopify.com/cdn/shop/files/Watch_Banner_7b3ae013-75a3-479c-a76f-7c2eea9d4a9e_360x.png?v=1696738786"
                alt="Ecommerce Product Deal">
        </div>
        <div class="deals-product-sec-items-wrap">
            @for ($a = 0; $a <= 6; $a++)
                <x-product.card />
            @endfor
        </div>

    </div>
</section>
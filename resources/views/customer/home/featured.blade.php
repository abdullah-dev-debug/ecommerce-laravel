<section class="featured-product-section">
    <div class="main-container">
        <div class="featured-product-sec-header">
            <h2>Trending Products</h2>
        </div>
        <div class="featured-product-tabs-wrap">
            <a href="javascript:void(0)" class="featured-product-tab active">Mobile</a>
            <a href="javascript:void(0)" class="featured-product-tab ">Watch</a>
        </div>
        <div class="featured-product-items-wrap">
            @foreach ($products as $product)
            <x-product.card :product="$product"  />
            @endforeach
        </div>

    </div>
</section>
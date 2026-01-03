<div class="card product-form-container">
    <div class="product-form-header card-header">
        <h3>Product Images</h3>
    </div>

    <div class="card-body">

        {{-- Thumbnail --}}
        <div class="fm-group product-form-field-contain">
            <label>Thumbnail</label>

            <input type="file" name="thumbnail" class="form-control file-input">

            @if (!empty($product->thumbnail))
                <div class="prefill-wrapper">
                    <div class="fp-item prefill-thumb shadow-sm">
                        <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->title }}" class="img-fluid rounded">
                    </div>
                </div>
            @else
                <x-file-preview width="300" height="300" alt="Product Thumbnail" />
            @endif
        </div>


        <div class="fm-group product-form-field-contain">
            <label>Gallery Images</label>

            <input type="file" name="gallery_photos[]" multiple class="form-control file-input">

            @if (!empty($product->gallery))
                <div class="prefill-wrapper ">
                    <div class="row g-3 mt-3">
                        @foreach ($product->gallery as $image)
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="fp-item prefill-card shadow-sm">
                                    <img src="{{ asset($image->path) }}" alt="{{ $product->title }}" class="img-fluid rounded">
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @else
                <x-file-preview width="300" height="300" alt="Gallery" containerClasss="fp-grid-3" />
            @endif
        </div>

    </div>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-expand-alt text-success me-2"></i> Sizes
            </h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#sizeModal" >
                <i class="fa fa-plus me-1"></i> Add Size
            </button>
        </div>
    </div>
    
    <div class="card-body p-0" id="sizeTableContainer">
        @include('admin.catalog.attributes.partials._size_table', ['sizes' => $sizes])
    </div>
</div>
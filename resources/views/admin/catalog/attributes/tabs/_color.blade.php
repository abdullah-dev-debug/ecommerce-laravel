<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-palette text-primary me-2"></i> Colors
            </h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#colorModal" >
                <i class="fa fa-plus me-1"></i> Add Color
            </button>
        </div>
    </div>
    
    <div class="card-body p-0" id="colorTableContainer">
        @include('admin.catalog.attributes.partials._color_table', ['colors' => $colors])
    </div>
</div>
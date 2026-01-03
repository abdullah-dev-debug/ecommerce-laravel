<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-ruler-combined text-info me-2"></i> Units
            </h5>
            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#unitModal" >
                <i class="fa fa-plus me-1"></i> Add Unit
            </button>
        </div>
    </div>
    
    <div class="card-body p-0" id="unitTableContainer">
        @include('admin.catalog.attributes.partials._unit_table', ['units' => $units])
    </div>
</div>
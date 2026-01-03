@extends('admin.layout.app')
@php
    $title = "Attributes Management";
@endphp

@section('title', $title)

@section('content')
    <div class="myPage-container">
        <div class="myPage-inner-container">
            <!-- Page Header -->
            <div class="myPage-header">
                <div>
                    <h3 class="mb-0 fw-bold">{{ $title }}</h3>
                    <p class="text-muted mb-0">Manage colors, sizes, and measurement units</p>
                </div>
                <div class="myPage-item-align-end">
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#helpModal">
                        <i class="fa fa-question-circle me-2"></i> Help
                    </button>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="attributesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="colors-tab" data-bs-toggle="tab" data-bs-target="#colors"
                        type="button" role="tab">
                        <i class="fa fa-palette me-2"></i> Colors
                        <span class="badge bg-primary ms-2" id="colorCount">{{ $attributes['colors']->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sizes-tab" data-bs-toggle="tab" data-bs-target="#sizes" type="button"
                        role="tab">
                        <i class="fa fa-expand-alt me-2"></i> Sizes
                        <span class="badge bg-success ms-2" id="sizeCount">{{ $attributes['sizes']->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="units-tab" data-bs-toggle="tab" data-bs-target="#units" type="button"
                        role="tab">
                        <i class="fa fa-ruler-combined me-2"></i> Units
                        <span class="badge bg-info ms-2" id="unitCount">{{ $attributes['units']->count() }}</span>
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="attributesTabContent">
                <!-- Colors Tab -->
                <div class="tab-pane fade show active" id="colors" role="tabpanel">
                    @include('admin.catalog.attributes.tabs._color', ['colors' => $attributes['colors']])
                </div>

                <!-- Sizes Tab -->
                <div class="tab-pane fade" id="sizes" role="tabpanel">
                    @include('admin.catalog.attributes.tabs._size', ['sizes' => $attributes['sizes']])
                </div>

                <!-- Units Tab -->
                <div class="tab-pane fade" id="units" role="tabpanel">
                    @include('admin.catalog.attributes.tabs._unit', ['units' => $attributes['units']])
                </div>
            </div>
        </div>
    </div>

    @include('admin.catalog.attributes._modals')

@endsection

@section('scripts')
    @include('admin.partial._scripts')
    @include('admin.catalog.attributes._scripts')
@endsection
@extends('admin.layout.app')

@php
    $title = "Edit Product Page";
@endphp

@section('title', $title)

@section('content')
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.product.partial.basic-info', ['product' => $product])
        @include('admin.product.partial.attributes', [
            'colors' => $data['colors'],
            'sizes' => $data['sizes'],
            'categories' => $data['categories'],
            'subCategories' => $data['subCategories'],
            'brands' => $data['brands'],
            "units" => $data['units'],
            'product' => $product
        ])
        @include('admin.product.partial.inventory', ['product' => $product])
        @include('admin.product.partial.pricing-tax', ['product' => $product])
        @include('admin.product.partial.product-image', ['product' => $product])
        @include('admin.product.partial.seo-information', ['product' => $product])
        @include('admin.product.partial.flags', ['product' => $product])
        <div class="myPage-item-align-end mb-3">
            <a href="{{ route('admin.products.list') }}" class="bs-btn bs-btn-cancel">
                Cancel
            </a>
            <button type="submit" class="bs-btn bs-btn-primary">
             <i class="fa fa-save"></i>   Save Changes 
            </button>
        </div>
    </form>


@endsection


@section('scripts')
    @include('admin.product._scripts')
    @include('admin.partial._scripts')
@endsection
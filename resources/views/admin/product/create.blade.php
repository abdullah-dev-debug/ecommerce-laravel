@extends('admin.layout.app')

@php
    $title = "Create Product Page";
@endphp

@section('title', $title)

@section('content')

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" >
    @csrf

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    @include('admin.product.partial.basic-info')
    @include('admin.product.partial.attributes', [
    'colors' => $data['colors'], 
    'sizes' => $data['sizes'],
    'categories' => $data['categories'],
    'subCategories' => $data['subCategories'],
    'brands' => $data['brands'],
    "units" => $data['units']
    ])
    @include('admin.product.partial.inventory')
    @include('admin.product.partial.pricing-tax')
    @include('admin.product.partial.product-image')
    @include('admin.product.partial.seo-information')
    @include('admin.product.partial.flags')
    <div class="myPage-item-align-end mb-3">
        <a href="{{ route('admin.products.list') }}" class="bs-btn bs-btn-cancel">
            Cancel
        </a>
        <button type="submit" class="bs-btn bs-btn-primary">
         <i class="fa fa-save"></i>   Save Product 
        </button>
    </div>
</form>

@endsection


@section('scripts')
@include('admin.product._scripts')
@include('admin.partial._scripts')
@endsection
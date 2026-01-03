@extends('admin.layout.app')

@php
    $title = "Products Management";
@endphp

@section('title', $title)

@section('content')
<div class="myPage-container card">
    <div class="myPage-inner-container">
<div class="myPage-header">
            <h4>All Products</h4>
            <a href="{{ route('admin.products.create') }}" class="bs-btn bs-btn-primary">
                <i class="fa fa-plus"></i> Add New Product
            </a>
        </div>
      @include('admin.product._table',['actions' => true])
    </div>
</div>
@endsection

@section('scripts')
    @include('admin.partial._scripts')
@endsection

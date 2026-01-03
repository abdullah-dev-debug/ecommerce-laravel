@extends("admin.layout.app")
@php
$title = "Vendor Products Management";
@endphp
@section("title", $title)
@section("content")
<div class="myPage-container card">
    <div class="myPage-inner-container">
        <div class="myPage-header">
            <h4>All Vendor Products</h4>
        </div>
      @include('admin.product._table',['products' => $vendorProducts, 'actions' => false])
    </div>
@endsection

@section('scripts')
    @include('admin.partial._scripts')
@endsection

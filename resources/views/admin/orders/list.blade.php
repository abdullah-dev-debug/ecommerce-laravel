@extends("admin.layout.app")
@php
$title = "Orders Management";
@endphp
@section("title",$title)
@section("content")
<div class="myPage-container">
    <div class="myPage-header">
        <h4>All Orders</h4>
        <a href="#" class="bs-btn bs-btn-primary">
            <i class="fa fa-plus"></i> Add New Order
        </a>
    </div>
    <div class="card mt-4">
        <div class="myPage-inner-container">
            @include('admin.orders.partial._table')
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('admin.partial._scripts')
@endsection
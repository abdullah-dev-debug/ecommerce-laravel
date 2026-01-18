@extends("admin.layout.app")

@php
    $title = "Vendors Management";
@endphp

@section('title', $title)

@section('content')
    <div class="myPage-container">
        <div class="myPage-header">
            <h4>All Vendors</h4>
            <a href="{{ route('admin.vendor.create') }}" class="bs-btn bs-btn-primary">
                <i class="fa fa-plus"></i> Add New Vendor
            </a>
        </div>


        <div class="card">
            <div class="myPage-inner-container">
                @include('admin.vendors.partials._vendor_table',['action'=> true])
            </div>
        </div>
    </div>
@endsection


@extends("admin.layout.app")

@php
    $title = "Add New Vendor";
@endphp

@section('title', $title)

@section('content')
    <div class="myPage-container">
        @include('admin.vendors.partials._vendor_form', ['action' => route('admin.vendor.store'), 'vendor' => null])
    </div>

@endsection

@extends("admin.layout.app")

@php
   $title = "Edit Vendor — {$vendor->name}";

@endphp

@section('title', $title)

@section('content')
    <div class="myPage-container">
        @include('admin.vendors.partials._vendor_form', ['action' => route('admin.vendor.update',["vendor"=>$vendor->id]), 'vendor' => $vendor])
    </div>

@endsection

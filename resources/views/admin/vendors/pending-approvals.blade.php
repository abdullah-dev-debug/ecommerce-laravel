@extends("admin.layout.app")

@php
    $title = "Pending Vendors Management";
@endphp

@section('title', $title)

@section('content')
    <div class="myPage-container">
        <div class="myPage-header">
            <h4>All Vendor Requests</h4>
        </div>

        <div class="card">
            <div class="myPage-inner-container">
                @include('admin.vendors.partials._vendor_table',['action'=> false])
            </div>
        </div>
    </div>
@endsection

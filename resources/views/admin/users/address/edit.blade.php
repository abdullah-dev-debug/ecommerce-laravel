@extends('admin.layout.app')
@php
    $title = "Address Create Page";
@endphp
@section('title', $title)
@section('content')
    <div class="myPage-container">
        <form action="{{ route('admin.user.address.update',[" address"=> $address->id]) }}" method="POST">
            <div class="card myPage-inner-container">
                <div class="myPage-header">
                    <h4>{{ $title }}</h4>
                </div>
            @csrf
            @method('PUT')
            @include(
             "admin.users.address.partial._address_form", 
             ["address" => $address,"comanData"=> $comanData]
                )
            </div>
            <div class="myPage-item-align-end mb-4 mt-4">
                <a href="{{ route('admin.user.address.list') }}" class="bs-btn bs-btn-cancel">
                    Cancel
                </a>
                <button type="submit" class="bs-btn bs-btn-primary">
                    Save Address
                </button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    @include('admin.partial._scripts')
@endsection
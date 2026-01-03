@extends('admin.layout.app')
@php
    $title = "Create Brand Page";
@endphp

@section('title', $title)

@section('content')
    <div class="myPage-container">
        <form action="{{ route('admin.catalog.brand.store') }}" method="post">
            <div class="card">
                <div class="myPage-inner-container">
                    <h4 class="mb-4">{{ $title }}</h4>
                    @csrf
                    <div class="fm-group">
                        <label for="brand-icon">Icon</label>
                        <input type="file" name="icon" id="brand-icon" class="form-control file-input">
                        <x-file-preview width="160" height="160" alt="Brand Icon" />
                    </div>
                    <div class="fm-group">
                        <label for="brand-name">Name</label>
                        <input type="text" name="name" id="brand-name" placeholder="Enter Brand Name" class="form-control">
                    </div>
                    <div class="fm-group">
                        <label for="brand-url">Url</label>
                        <input type="text" name="slug" id="brand-url" placeholder="Enter Brand Url" class="form-control">
                    </div>
                    <div class="fm-group">
                        <label for="brand-status">Status</label>
                        <select name="status" id="brand-status" class="form-select">
                            <option value="0" disabled selected>Select Brand Status</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="myPage-item-align-end mt-4">
                <a href="{{ route('admin.catalog.brand.list') }}" class="bs-btn bs-btn-cancel">
                    Cancel
                </a>
                <button type="submit" class="bs-btn bs-btn-primary">
                    Create Brand
                </button>
            </div>
        </form>

    </div>
@endsection

@section('scripts')
@include('admin.partial._scripts')
@endsection
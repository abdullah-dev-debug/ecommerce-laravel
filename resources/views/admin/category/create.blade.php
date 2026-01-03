@extends('admin.layout.app')
@php
    $title = "Create Category Page";
@endphp
@section('title')
    {{ $title }}
@endsection


@section('content')
    <form action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" method="post" class="myPage-container">
        <div class="card">
            <div class="myPage-inner-container">
                <div class="myPage-header">
                    <h4> Create Category</h4>
                </div>
                <div class="myPage-form-wrap">
                    @csrf
                    <div class="fm-group">
                        <label for="category-icon">Icon</label>
                        <input type="file" name="icon" id="category-icon" class="form-control file-input">
                        <x-file-preview alt="Category Icon" width="214" height="214" />
                    </div>
                    <div class="fm-group">
                        <label for="category-name">Name</label>
                        <input type="text" placeholder="Enter Category Name" class="form-control" name="name"
                            id="category-name">
                    </div>
                    <div class="fm-group">
                        <label for="category-slug">Slug</label>
                        <input type="text" placeholder="Enter Category Slug" name="slug" id="category-slug"
                            class="form-control">
                    </div>
                    <div class="fm-group">
                        <label for="category-status">Status</label>
                        <select name="status" id="category-status" class="form-select">
                            <option value="" disabled selected>Select Category Status</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="myPage-item-align-end mt-3">
            <a href="{{ route('admin.categories.list') }}" class="bs-btn bs-btn-cancel">
                Cancel
            </a>
            <button type="submit" class="bs-btn bs-btn-primary">
                Save
            </button>
        </div>
    </form>
@endsection
@section('scripts')
@include('admin.partial._scripts')
@endsection
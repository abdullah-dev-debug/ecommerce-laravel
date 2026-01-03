@extends('admin.layout.app')

@php
    $title = "Edit Sub Category";
@endphp

@section('title')
    {{ $title }}
@endsection

@section('content')
    <form action="{{ route('admin.subcategories.update', ['subcategory' => $subCategory->id]) }}" enctype="multipart/form-data" method="post"
        class="myPage-container">

        @csrf
        @method('PUT')

        <div class="card">
            <div class="myPage-inner-container">

                <div class="myPage-header">
                    <h4>Edit Sub Category</h4>
                </div>

                <div class="myPage-form-wrap">
                    <div class="fm-group">
                        <label for="category-icon">Icon</label>
                        <input type="file" name="icon" id="category-icon" class="form-control file-input">

                        <x-file-preview path="{{ $subCategory->icon ? asset($subCategory->icon) : null }}" alt="Category Icon"
                            width="214" height="214" />
                    </div>
                    <div class="fm-group">
                        <label for="category-list">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $subCategory->category_id === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fm-group">
                        <label for="category-name">Name</label>
                        <input type="text" placeholder="Enter Category Name" class="form-control" name="name"
                            id="category-name" value="{{ old('name', $subCategory->name) }}">
                    </div>
                    <div class="fm-group">
                        <label for="category-slug">Slug</label>
                        <input type="text" placeholder="Enter Category Slug" name="slug" id="category-slug"
                            class="form-control" value="{{ old('slug', $subCategory->slug) }}">
                    </div>

                    {{-- Status --}}
                    <div class="fm-group">
                        <label for="category-status">Status</label>
                        <select name="status" id="category-status" class="form-select">
                            <option value="1" {{ $subCategory->status == 1 ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="0" {{ $subCategory->status == 0 ? 'selected' : '' }}>
                                In Active
                            </option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <div class="myPage-item-align-end mt-3">
            <a href="{{ route('admin.subcategories.list') }}" class="bs-btn bs-btn-canel">
                Cancel
            </a>

            <button type="submit" class="bs-btn bs-btn-primary">
                Update
            </button>
        </div>

    </form>
@endsection

@section('scripts')
@include('admin.partial._scripts')
@endsection
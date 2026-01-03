@extends('admin.layout.app')

@php
    $title = "Category Management";
@endphp

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="myPage-container">

        {{-- Header --}}
        <div class="myPage-header">
            <h4>All Categories</h4>
            <a href="{{ route('admin.categories.create') }}" class="bs-btn bs-btn-primary">
                <i class="fa fa-plus"></i> Add New Category
            </a>
        </div>

        {{-- Table --}}
        <div class="card mt-4">
            <div class="myPage-inner-container">
                @if (!empty($categories) && $categories->isNotEmpty())
    <div class="responsive-table">
        <table class="table table-bordered load_dataTable_fn align-middle mt-4">
            <thead>
                <tr>
                    <th width="100">Icon</th>
                    <th>Name</th>
                    <th width="120">Status</th>
                    <th width="140">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td class="text-center">
                            @if ($category->icon)
                                <img src="{{ asset($category->icon) }}"
                                     alt="{{ $category->name }}" width="60">
                            @else
                                <span class="text-muted">No Icon</span>
                            @endif
                        </td>

                        <td>{{ $category->name }}</td>

                        <td>
                            @if ($category->status == 1)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger delete-confirm-btn"
                                        data-title="Delete Category"
                                        data-text="Are you sure you want to delete '{{ $category->name }}' category?">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>

                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                               class="btn btn-info">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@else
    <div class="d-flex justify-content-center align-items-center py-5">
        <span class="text-muted">No categories found</span>
    </div>
@endif

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.partial._scripts')
@endsection
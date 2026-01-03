@extends('admin.layout.app')

@php
$title = "Sub Categories Management";
@endphp

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="myPage-container">
    <div class="myPage-header">
        <h4>All Sub Categories</h4>
        <a href="{{ route('admin.subcategories.create') }}" class="bs-btn bs-btn-primary">
            <i class="fa fa-plus"></i> Add New Category
        </a>
    </div>

    <div class="card mt-4">
        <div class="myPage-inner-container">
            <div class="responsive-table">
                <table
                    class="table table-bordered {{ $subCategories->isNotEmpty() ? 'load_dataTable_fn' : '' }} align-middle mt-4">

                    <thead>
                        <tr>
                            <th width="100">Icon</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th width="120">Status</th>
                            <th width="140">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($subCategories as $category)
                        <tr>
                            <td class="text-center">
                                @if($category->icon)
                                <img src="{{ asset($category->icon) }}" alt="{{ $category->name }}" width="60">
                                @else
                                <img src="https://placehold.co/60x60" alt="{{ $category->name ?? 'default-table-image' }}">
                                @endif
                            </td>
                            <td> {{ $category->category->name ?? 'N/A' }} </td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if ($category->status == 1)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.subcategories.destroy', $category->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-confirm-btn"
                                        data-title="Delete Category"
                                        data-text="Are you sure you want to delete '{{ $category->name }}' sub category?">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.subcategories.edit', $category->id) }}" class="btn btn-info">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <p class="text-muted mb-2">No Sub categories found.</p>
                                <a href="{{ route('admin.subcategories.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i> Add First Category
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('admin.partial._scripts')
@endsection
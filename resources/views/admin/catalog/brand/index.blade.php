@extends('admin.layout.app')
@php
    $title = "Brand Management";
@endphp
@section('title', $title)

@section('content')
    <div class="myPage-container">
        <div class="card">
            <div class="myPage-inner-container">
                <div class="myPage-header">
                    <h4>All Brands</h4>
                    <a href="{{ route('admin.catalog.brand.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Brand
                    </a>
                </div>
                @if (!empty($brands) && $brands->isNotEmpty())
                    <div class="responsive-table">
                        <table class="table table-bordered load_dataTable_fn ">
                            <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>
                                            <img src="https://placehold.co/80x80" alt="Brand Icon">
                                        </td>
                                        <td>
                                            {{ $brand->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.catalog.brand.status', ['brand' => $brand->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn {{ $brand->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                    {{ $brand->status == 1 ? 'Active' : 'In Active' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="table-action-col">
                                                <form action="{{ route('admin.catalog.brand.destroy', ['brand' => $brand->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger delete-confirm-btn"
                                                        data-title="Delete Brand"
                                                        data-text="Are you sure you want to delete '{{ $brand->name }}' Brand?">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.catalog.brand.edit', ['brand' => $brand->id])  }}"
                                                    class="btn btn-info text-white">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else
                    <div class="d-flex justify-content-center align-items-center py-5">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fa fa-tags fa-3x text-muted"></i>
                            </div>

                            <h5 class="fw-semibold mb-2">No Brands Found</h5>
                            <p class="text-muted mb-4">
                                You haven’t added any brands yet. Start by creating your first brand
                                to organize your products efficiently.
                            </p>

                            <a href="{{ route('admin.catalog.brand.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus me-1"></i> Add New Brand
                            </a>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')
@include('admin.partial._scripts')
@endsection
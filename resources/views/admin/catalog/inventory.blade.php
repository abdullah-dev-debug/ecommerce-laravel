@extends('admin.layout.app')

@php
$title = "Inventory Management";
@endphp
@section('title', $title)

@section('content')
<div class="myPage-container card">
    <div class="myPage-inner-container">
        <div class="myPage-header">
            <h4>Inventory Management</h4>
        </div>

        @if($products->isNotEmpty())
        <div class="responsive-table">
            <table class="table table-bordered table-hover align-middle load_dataTable_fn mt-3">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Low Stock Threshold</th>
                        <th>Stock Status</th>
                        <th>Vendor</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->low_stock_threshold }}</td>
                        <td>
                            @if($product->quantity == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($product->quantity <= $product->low_stock_threshold)
                                <span class="badge bg-warning">Low</span>
                            @else
                                <span class="badge bg-success">OK</span>
                            @endif
                        </td>
                        <td>{{ $product->vendor?->name ?? '-' }}</td>
                        <td>{{ ucfirst(str_replace('_',' ',$product->status)) }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-info">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="card mt-4">
            <div class="card-body text-center">
                <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Low Stock Products</h5>
                <p class="text-muted mb-0">
                    All products are sufficiently stocked at the moment.
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
    @include('admin.partial._scripts')
@endsection

@php
    $actions = $actions ?? true;
@endphp

@if($products->isNotEmpty())
    <div class="responsive-table">
        <table class="table table-bordered table-hover align-middle load_dataTable_fn mt-3">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Thumbnail</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Created By</th>
                    <th>Status</th>
                    @if ($actions == true)
                    <th>Action</th>
                    @endif
                    
                </tr>
            </thead>

            <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>
                            <img src="{{ asset($product->thumbnail) }}" class="img-thumbnail" width="60">
                        </td>

                        <td>
                            <span class="badge bg-secondary">{{ $product->sku }}</span>
                        </td>

                        <td>₹ {{ number_format($product->price, 2) }}</td>

                        <td>
                            @if($product->quantity <= $product->low_stock_threshold)
                                <span class="badge bg-danger">Low ({{ $product->quantity }})</span>
                            @else
                                <span class="badge bg-success">{{ $product->quantity }}</span>
                            @endif
                        </td>

                        <td>
                            @if($product->admin)
                                <span class="badge bg-primary">Admin</span>
                            @elseif($product->vendor)
                                <span class="badge bg-info">Vendor</span>
                            @else
                                <span class="badge bg-secondary">System</span>
                            @endif
                        </td>

                        <td>
                            @php
                                $statusClass = match ($product->status) {
                                    'active' => 'bg-success',
                                    'inactive' => 'bg-secondary',
                                    'draft' => 'bg-warning',
                                    'out_of_stock' => 'bg-danger',
                                    default => 'bg-light'
                                };
                            @endphp

                            <button type="submit" class="badge {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                            </button>
                        </td>
                    @if ($actions == true)
                        <td>
                            <div class="table-action-col">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info ">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger  delete-confirm-btn" data-title="Delete Product"
                                        data-text="Are you sure you want to delete this product?">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@else
    <div class="card mt-4">
        <div class="card-body text-center">
            <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No Products Found</h5>
            <p class="text-muted mb-0">
                There are no products available at the moment.
            </p>

        </div>
    </div>
@endif
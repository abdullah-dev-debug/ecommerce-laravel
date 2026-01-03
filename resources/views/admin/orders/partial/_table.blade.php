@if($orders && $orders->isNotEmpty())

    <table class="table table-bordered table-striped load_dataTable_fn">
        <thead>
            <tr>
                <th>#</th>
                <th>Order No</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Order Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->order_number ?? '—' }}</td>

                    <td>
                        {{ $order->customer?->name ?? 'Guest' }}<br>
                        <small>{{ $order->customer?->email ?? '—' }}</small>
                    </td>

                    <td>{{ $order->items?->count() ?? 0 }}</td>

                    <td>₹ {{ number_format($order->total_amount ?? 0, 2) }}</td>

                    <td>
                        <span class="badge bg-info">
                            {{ ucfirst($order->latestTransactionStatus() ?: 'unpaid') }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-warning">
                            {{ ucfirst($order->status ?? 'pending') }}
                        </span>
                    </td>

                    <td>{{ optional($order->created_at)->format('d M Y') ?? '—' }}</td>

                    <td>
                        <a href="#" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@else
    {{-- EMPTY STATE --}}
    <div class="text-center py-5">
        <h5>No orders yet</h5>
        <p class="text-muted mb-0">
            Orders will appear here once customers start placing them.
        </p>
    </div>
@endif

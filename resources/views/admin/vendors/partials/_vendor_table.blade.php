@if ($vendors && $vendors->isNotEmpty())
    <div class="responsive-table">
        <table class="table table-bordered load_dataTable_fn mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Orders</th>
                    <th>Ip</th>
                    <th>Status</th>
                    @if ($action)
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($vendors as $key => $vendor)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->email }}</td>
                        <td>{{ $vendor->orders_count ?? 0}}</td>
                        <td>{{ $vendor->ip }}</td>
                        <td> <span class="badge {{ $vendor->status == 'active' ? 'bg-success' : 'bg-danger' }}"
                                style="text-transform: capitalize !important"> {{ $vendor->status  }}</span></td>
                        @if ($action)
                            <td>
                                <div class="table-action-col">
                                    <a href="{{ route('admin.vendor.edit', $vendor->id) }}" class="btn btn-info">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.vendor.destroy', $vendor->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-confirm-btn" data-title="Delete Vendor"
                                            data-text="Are you delete {{ $vendor->name }} Vendor">
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
    @include('admin.partial._empty_state', [
        "title" => "Vendors Not Found",
        "subtitle" => "No vendor available at the moment",
        "buttonLink" => route('admin.vendor.create'),
        "buttonText" => "Create Vendor"
    ])
@endif
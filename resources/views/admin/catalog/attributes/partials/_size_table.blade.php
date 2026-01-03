@if($sizes->isEmpty())
    <div class="text-center py-5">
        <i class="fa fa-expand-alt fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No sizes found</h5>
        <p class="text-muted">Add your first size to get started</p>
        <button class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#sizeModal" onclick="resetSizeForm()">
            <i class="fa fa-plus me-1"></i> Add First Size
        </button>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="50">#</th>
                    <th>Size Name</th>
                    <th>Size Code</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th width="130">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sizes as $index => $size)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $size->name }}</td>
                        <td><code>{{ $size->code ?? 'N/A' }}</code></td>
                        <td class="small text-muted">{{ $size->description ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $size->status ? 'success' : 'danger' }}">
                                {{ $size->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="item-wrap" role="group">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#sizeModal"
                                    class="btn btn-outline-primary edit-size" data-id="{{ $size->id }}"
                                    data-name="{{ $size->name }}" data-status="{{ $size->status }}"
                                    data-code="{{ $size->code }}"
                                    data-description="{{ $size->description }}"
                                    >
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.attributes.size.status', ["size" => $size->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-success toggle-size-status"
                                        data-id="{{ $size->id }}" data-status="{{ $size->status }}">
                                        <i class="fa fa-power-off"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.attributes.size.destroy', ["size" => $size->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" data-title="Delete Size"
                                        data-text="Are you sure you want to delete '{{ $size->name }}' Size?"
                                        class="btn btn-outline-danger delete-confirm-btn" data-id="{{ $size->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
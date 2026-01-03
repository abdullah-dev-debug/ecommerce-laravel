@if($units->isEmpty())
    <div class="text-center py-5">
        <i class="fa fa-ruler-combined fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No units found</h5>
        <p class="text-muted">Add your first unit to get started</p>
        <button class="btn btn-info mt-2" data-bs-toggle="modal" data-bs-target="#unitModal" >
            <i class="fa fa-plus me-1"></i> Add First Unit
        </button>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="50">#</th>
                    <th>Unit Name</th>
                    <th>Symbol</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th width="130">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($units as $index => $unit)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $unit->name }}</td>
                        <td><code>{{ $unit->symbol ?? 'N/A' }}</code></td>
                        <td>
                            <span class="badge bg-{{ $unit->type == 'weight' ? 'warning' : 'primary' }}">
                                {{ ucfirst($unit->type ) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $unit->status ? 'success' : 'danger' }}">
                                {{ $unit->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="item-wrap" role="group">
                                <button type="button" class="btn btn-outline-primary edit-unit"
                                data-bs-toggle="modal" data-bs-target="#unitModal" data-id="{{ $unit->id }}"
                                    data-name="{{ $unit->name }}" data-symbol="{{ $unit->symbol }}"
                                    data-type="{{ $unit->type }}" data-status="{{ $unit->status }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.attributes.unit.status', ["unit" => $unit->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-success toggle-unit-status"
                                        data-id="{{ $unit->id }}" data-status="{{ $unit->status }}">
                                        <i class="fa fa-power-off"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.attributes.unit.destroy', ["unit" => $unit->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger delete-unit delete-confirm-btn" data-title="Delete Unit"
                                        data-text="Are you sure you want to delete '{{ $unit->name }}' Color?"
                                        data-id="{{ $unit->id }}">
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
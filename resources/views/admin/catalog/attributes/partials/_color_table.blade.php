@if($colors->isEmpty())
    <div class="text-center py-5">
        <i class="fa fa-palette fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No colors found</h5>
        <p class="text-muted">Add your first color to get started</p>
        <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#colorModal" >
            <i class="fa fa-plus me-1"></i> Add First Color
        </button>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="50">#</th>
                    <th>Color Name</th>
                    <th>Color Code</th>
                    <th>Preview</th>
                    <th>Status</th>
                    <th width="130">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($colors as $index => $color)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $color->name }}</td>
                        <td><code>{{ $color->code ?? 'N/A' }}</code></td>
                        <td>
                            <div class="myPage-item-align-center">
                                <div class="color-preview" style="background-color: {{ $color->code ?? '#6c757d' }}; 
                                                                                    width: 24px; height: 24px; 
                                                                                    border-radius: 4px; 
                                                                                    border: 1px solid #dee2e6;"
                                    title="{{ $color->code ?? 'No color code' }}">
                                </div>
                                <span class="ms-2 small">{{ $color->code ?? 'No code' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $color->status ? 'success' : 'danger' }}">
                                {{ $color->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="item-wrap" role="group">
                                <button type="button" class="btn btn-outline-primary edit-color" data-bs-toggle="modal" data-bs-target="#colorModal"
                                    data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-code="{{ $color->code }}"
                                    data-status="{{ $color->status }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.attributes.color.status', ["color" => $color->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-success toggle-color-status"
                                        data-id="{{ $color->id }}" data-status="{{ $color->status }}">
                                        <i class="fa fa-power-off"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.attributes.color.destroy', ["color" => $color->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger delete-color delete-confirm-btn" data-id="{{ $color->id }}"
                                        data-title="Delete Color"
                                        data-text="Are you sure you want to delete '{{ $color->name }}' Color?">
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
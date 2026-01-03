@extends('admin.layout.app')

@php
    $title = 'Product Reviews Management';
@endphp

@section('title', $title)

@section('content')
<div class="myPage-container card">
    <div class="myPage-inner-container">

        <div class="myPage-header">
            <h4>All Products Reviews</h4>
        </div>

        @if ($reviews->isNotEmpty())
            <div class="responsive-table">
                <table class="table table-bordered table-hover align-middle load_dataTable_fn mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>SKU</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Approved</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($reviews as $index => $review)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $review->product->sku ?? 'N/A' }}</td>
                                <td>{{ $review->customer->name ?? 'N/A' }}</td>
                                <td>{{ $review->rating }}</td>
                                <td>
                                    @if ($review->is_approved)
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-action-col d-flex gap-1">
                                        <a href="javascript:void(0)"
                                           class="btn btn-info"
                                           data-bs-toggle="modal"
                                           data-bs-target="#editReviewModal{{ $review->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.catalog.reviews.destroy', $review->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger delete-confirm-btn"
                                                    data-title="Delete Review"
                                                    data-text="Are you sure you want to delete this review?">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Edit Review Modal -->
                                    <div class="modal fade"
                                         id="editReviewModal{{ $review->id }}"
                                         tabindex="-1"
                                         aria-labelledby="editReviewLabel{{ $review->id }}"
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editReviewLabel{{ $review->id }}">
                                                        Edit Review
                                                    </h5>
                                                    <button type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                    </button>
                                                </div>

                                                <form action="{{ route('admin.catalog.reviews.update', $review->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="rating-status-{{ $review->id }}">
                                                                Rating Status
                                                            </label>
                                                            <select name="is_approved"
                                                                    id="rating-status-{{ $review->id }}"
                                                                    class="form-control">
                                                                <option value="1"
                                                                    {{ $review->is_approved ? 'selected' : '' }}>
                                                                    Approved
                                                                </option>
                                                                <option value="0"
                                                                    {{ !$review->is_approved ? 'selected' : '' }}>
                                                                    Pending
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button"
                                                                class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit"
                                                                class="btn btn-primary">
                                                            Save changes
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
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
                    <h5 class="text-muted">No Reviews Found</h5>
                    <p class="text-muted mb-0">
                        There are no reviews available at the moment.
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

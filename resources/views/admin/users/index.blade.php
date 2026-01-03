@extends('admin.layout.app')
@php
$title = 'Customers Management';
@endphp
@section('title', $title)
@section('content')

<div class="myPage-container">
    <div class="myPage-header">
        <h4>All Customers</h4>
        <a href="{{ route('admin.user.create') }}" class="bs-btn bs-btn-primary">
            <i class="fa fa-plus"></i> Add New Customer
        </a>
    </div>
    <div class="card">
        <div class="myPage-inner-container">
            @if ($users && $users->isNotEmpty())
            <div class="responsive-table">
                <table class="table table-bordered load_dataTable_fn mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Orders</th>
                            <th>Spent</th>
                            <th>Ip</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->orders_count ?? 0}}</td>
                            <td>{{ number_format($user->orders_count ?? 0,2)}}</td>
                            <td>{{ $user->ip }}</td>
                            <td>
                                <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->status == 1 ? 'Active' : 'Blocked' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M, Y') }}</td>
                            <td>
                                <div class="table-action-col">
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-info">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-confirm-btn" data-title="Delete Customer" data-text="Are you delete {{ $user->name }} Customer">
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
            @else
            <div class="text-center">
                <p>No customers found.</p>
            </div>
            @endif
        </div>
    </div>
</div>


@endsection

@section('scripts')
@include('admin.partial._scripts')
@endsection
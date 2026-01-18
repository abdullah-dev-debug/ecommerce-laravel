@extends('admin.layout.app')
@php
$title = 'Customers Address Management';
@endphp
@section('title', $title)

@section('content')
<div class="myPage-container">
    <div class="myPage-header">
        <h4>All Customer Addresses</h4>
        <a href="{{ route('admin.user.address.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add New Address
        </a>
    </div>
    <div class="card">
        <div class="myPage-inner-container">
@if ($addresses->isNotEmpty())
            <table class="table table-bordered load_dataTable_fn">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
              <tbody>
@foreach ($addresses as $address)
<tr>
    <td>
        {{ $address->customer?->name ?? $address->first_name ?? 'N/A' }}

        @if($address->customer?->trashed())
            <span class="badge bg-warning ms-1">Deleted</span>
        @endif
    </td>

    <td>{{ $address->customer?->email ?? $address->email ?? 'N/A' }}</td>

    <td>{{ $address->country?->name ?? 'N/A' }}</td>

    <td>{{ ucfirst($address->address_type ?? 'N/A') }}</td>

    <td>
        <div class="table-action-col">
            <a href="{{ route('admin.user.address.edit', ['address' => $address->id]) }}"
               class="btn btn-info">
                <i class="fa fa-edit"></i>
            </a>

            <form action="{{ route('admin.user.address.destroy', $address->id) }}"
                  method="POST"
                  style="display:inline-block;">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="btn btn-danger delete-confirm-btn"
                        data-title="Delete Address"
                        data-text="Are you sure you want to delete this address?">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@endforeach
</tbody>

            </table>
            @else
            @include('admin.partial._empty_state', [
            'icon' => 'fa-map-marker',
            'title' => 'No addresses found',
            'subtitle' => 'Looks like this customer hasn’t added any addresses yet.',
            'buttonText' => 'Add New Address',
            'buttonLink' => route('admin.user.address.create')
            ])
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('admin.partial._scripts')
@endsection
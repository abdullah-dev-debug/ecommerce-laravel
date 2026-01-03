@extends('admin.layout.app')
@php
$title = 'Edit Customer';
@endphp
@section('title', $title)
@section('content')
<data class="myPage-container">
    <form action="{{ route('admin.user.update', ['client'=>$user->id]) }}" method="POST">
        <div class="card">
            <div class="myPage-inner-container">
                <div class="myPage-header">
                    <h4>{{ $title }}</h4>
                </div>
                @csrf
                @method('PUT')
                @include('partials.validation-error')
                <div class="fm-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter Your Name" value="{{ old('name', $user->name) }}" class="form-control" required>
                </div>
                <div class="fm-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter Your Email" value="{{ old('email', $user->email) }}" class="form-control" required>
                </div>
                <div class="fm-group">
                    <label for="password">Password</label>
                    <div class="password-input-wrap">
                        <input type="text" placeholder="Enter your password" name="password" class="form-control password-input" autocomplete="off">
                        <i class="fa password-eye-btn fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Show password"></i>
                    </div>
                </div>
                <div class="fm-group">
                    <label for="customer-account-status">Status</label>
                    <select name="status" id="customer-account-status" class="form-select">
                        <option value="" disabled selected>Select Account Status</option>
                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="myPage-item-align-end mt-4 mb-4">
            <a href="{{ route('admin.user.list') }}" class="bs-btn bs-btn-cancel">
                Cancel
            </a>
            <button type="submit" class="bs-btn bs-btn-primary">Update Customer</button>
        </div>
    </form>
    </div>
    @endsection
    @section('scripts')
    @include('admin.partial._scripts')
    @endsection
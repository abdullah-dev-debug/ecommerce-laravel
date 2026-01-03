@extends('admin.auth.app')
@section('title')
    Register
@endsection

@section('content')
    <div class="pannel-auth-page-container">
        <div class="pannel-auth-page-form-container">
            <form action="{{ route('admin.register') }}" class="pannel-auth-form-wrap" method="post">
                <div class="auth-form-header">
                    <img src="{{ asset('assets/image/20945760.jpg') }}" alt="Admin Registration" width="120" class="mb-1">
                    <h2 class="auth-title">Create Admin Account</h2>
                    <p class="auth-subtitle">Register new administrator access</p>
                </div> @csrf
                <div class="fm-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" placeholder="Enter Full Name" name="name" class="form-control" autocomplete="off"
                        required>
                </div>
                <div class="fm-group">
                    <label for="email">Email</label>
                    <input type="text" placeholder="Enter Email" name="email" class="form-control" autocomplete="off"
                        required>
                </div>
                <div class="fm-group">
                    <label for="phone">Phone</label>
                    <input type="tel" placeholder="Enter Phone Number" name="phone" class="form-control" autocomplete="off"
                        required>
                </div>
                <div class="fm-group">
                    <label for="address">Address</label>
                    <input type="text" placeholder="Enter Address" name="address" class="form-control" autocomplete="off"
                        required>
                </div>
                <div class="fm-group">
                    <label for="password">Password</label>
                    <div class="password-input-wrap">
                        <input type="password" placeholder="Enter Password" name="password"
                            class="form-control password-input" autocomplete="off" required>
                        <i class="fa fa-eye-slash password-eye-btn"></i>
                    </div>
                </div>
                <div class="fm-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="password-input-wrap">
                        <input type="password" placeholder="Enter Confirm Password" name="confirm_password"
                            autocomplete="off" class="form-control password-input" required>
                        <i class="fa fa-eye-slash password-eye-btn"></i>
                    </div>
                </div>
                <button type="submit" class="bs-btn bs-btn-primary w-100">
                    CREATE ACCOUNT
                </button>
            </form>
            <div class="auth-footer text-center mt-4 pt-3 border-top">
                <p class="text-muted mb-2" style="font-size: 14px;">
                    Already have an admin account?
                </p>
                <a href="{{ url('ecommerce/admin/auth/login') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa fa-sign-in me-1"></i> Login to Existing Account
                </a>
            </div>
        </div>
    </div>
@endsection
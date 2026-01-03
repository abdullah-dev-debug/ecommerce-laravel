@extends('admin.auth.app')
@section('title')
    Login
@endsection

@section('content')
    <div class="pannel-auth-page-container">
        <div class="pannel-auth-page-form-container">
            <form action="{{ route('admin.login') }}" class="pannel-auth-form-wrap" method="post">
                <div class="auth-form-header">
                    <img src="{{ asset('assets/image/20945760.jpg') }}" alt="Admin Login" width="120" class="mb-1">
                    <h2 class="auth-title">Admin Login</h2>
                    <p class="auth-subtitle">Sign in to your administrator account</p>
                </div> 
                
                @csrf
                
                <div class="fm-group">
                    <label for="email">Email Address</label>
                    <input type="email" placeholder="Enter your email" name="email" class="form-control" autocomplete="off" required>
                </div>
                
                <div class="fm-group">
                    <label for="password">Password</label>
                    <div class="password-input-wrap">
                        <input type="password" placeholder="Enter your password" name="password"
                            class="form-control password-input" autocomplete="off" required>
                        <i class="fa fa-eye-slash password-eye-btn"></i>
                    </div>
                </div>

                <button type="submit" class="bs-btn bs-btn-primary w-100">
                    <i class="fa fa-sign-in-alt me-2"></i> LOGIN
                </button>
            </form>
            
            <div class="auth-footer text-center mt-4 pt-3 border-top">
                <p class="text-muted mb-2" style="font-size: 14px;">
                    Don't have an admin account?
                </p>
                <a href="{{ url('ecommerce/admin/auth/register') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa fa-user-plus me-1"></i> Create New Account
                </a>
            </div>
        </div>
    </div>
@endsection
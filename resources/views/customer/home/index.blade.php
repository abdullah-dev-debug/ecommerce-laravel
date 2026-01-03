@extends('customer.layout.app')
@section('title')
    Home
@endsection

@section('content')
    <main class="app-main-content">
        @include('customer.home.hero')
        @include('customer.home.featured',["products"=>$trendingProducts])
        @include('customer.home.ads')
        @include('customer.home.deals')
    </main>
@endsection
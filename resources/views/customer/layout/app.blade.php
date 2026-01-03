<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') | ShopSphere</title>
    <meta name="description"
        content="ShopSphere - Professional blue & green theme with clean, modern design. Perfect for international e-commerce">
       
    @include('customer.layout.head')
    @yield('styles')
</head>

<body>
    @include('customer.layout.header')
    @yield('content')
    @yield('script')
</body>

</html>
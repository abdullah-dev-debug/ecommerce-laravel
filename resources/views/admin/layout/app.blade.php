<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | ShopSphere</title>
    @include('admin.layout.head')
</head>

<body>
    @include('admin.layout.sidebar')
    @include('admin.layout.header')
    <!-- management  -->
    <main class="app-layout-main-content">
        @yield('content')
    </main>
    @yield('scripts')
    @include('admin.layout.footer')
</body>

</html>
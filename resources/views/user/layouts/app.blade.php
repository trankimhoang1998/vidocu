<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#3b82f6">

    {{-- Favicon & Icons --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- SEO Meta Tags --}}
    @stack('seo')

    <!-- Styles -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    {{-- Additional Styles --}}
    @stack('styles')
</head>
<body>
    <div id="app">
        @include('user.layouts.header')

        <main class="main-content">
            @yield('content')
        </main>

        @include('user.layouts.footer')
    </div>
</body>
</html>

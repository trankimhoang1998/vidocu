<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vidocu') }} - @yield('title', 'Home')</title>

    <!-- Styles -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
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

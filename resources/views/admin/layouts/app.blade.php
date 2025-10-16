<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vidocu') }} Admin - @yield('title', 'Dashboard')</title>

    <!-- Styles -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
</head>
<body class="admin-body">
    <div class="admin-app">
        @include('admin.layouts.header')

        <div class="admin-wrapper">
            @include('admin.layouts.sidebar')

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script>
        // Configure Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Display session messages
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if(session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>

    @stack('scripts')
</body>
</html>

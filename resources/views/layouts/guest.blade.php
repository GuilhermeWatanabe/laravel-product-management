<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'First Decision') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body class="container-lg">
        <div class="d-flex flex-column justify-content-center align-items-center min-vh-100">
            <div class="mb-4">
                <a href="/">
                    <x-application-logo class="text-secondary" style="width: 5rem; height: 5rem;"/>
                </a>
            </div>

            <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

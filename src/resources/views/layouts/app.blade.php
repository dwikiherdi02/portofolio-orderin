<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }} | {{ $title ?? '' }}</title> --}}
    <title>{{ config('app.name', 'Laravel') }} | {{ $page ?? '' }}</title>

    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container-fluid d-flex flex-column flex-md-row p-0 m-0">
        {{-- Sidebar --}}
        <x-sidebar />
        {{-- ./Sidebar --}}

        <div class="content order-1 order-md-2">
            {{-- Header --}}
            <x-header />
            {{-- ./Header --}}

            {{-- Main --}}
            <main class="container-fluid p-3">
                {{-- Content --}}
                <div class="row">
                    {{ $slot }}
                </div>
                {{-- ./Content --}}
            </main>
            {{-- ./Main --}}
        </div>
    </div>
</body>
</html>

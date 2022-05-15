<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @livewireStyles

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')



            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto bg-white my-4">
                    <div class="grid grid-cols-1 sm:grid-cols-4">
                        <div class="sidebar border-r bg-secondary min-h-[70vh] h-full text-base-100">
                            <ul class="menu">
                                <li class="hover-bordered"><a>Home</a></li>
                                <li class="hover-bordered"><a>Orders</a></li>
                                <li class="hover-bordered"><a>Orders</a></li>
                                <li><a>Item 3</a></li>
                            </ul>
                        </div>
                        <div class="content col-span-3 p-4">
                        {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        @livewireScripts
    </body>
</html>

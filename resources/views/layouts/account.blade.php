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
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')



            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto bg-white my-4 min-h-[90vh] sm:min-h-full">
                    <div class="grid grid-cols-1 sm:grid-cols-4">
                        <div class="hidden sm:block sidebar border-r bg-clip-padding min-h-[70vh] h-full">
                            <ul class="menu">
                                <li class="hover-bordered"><a href="{{ route('account.index') }}" class="flex justify-between @if(request()->routeIs('account.index')) active @endif">Home <x-fas-chevron-right class="w-4 h-4" /></a></li>
                                <li class="hover-bordered"><a href="{{ route('account.order.index') }}" class="flex justify-between @if(request()->routeIs('account.order.index')) active @endif">Orders <x-fas-chevron-right class="w-4 h-4" /></a></li>
                                <li class="hover-bordered"><a href="{{ route('account.transactions.index') }}" class="flex justify-between @if(request()->routeIs('account.transactions.index')) active @endif">Transactions <x-fas-chevron-right class="w-4 h-4" /></a></li>
                                <li class="hover-bordered"><a class="flex justify-between">Wishlist <x-fas-chevron-right class="w-4 h-4" /></a></li>
                                <li class="hover-bordered"><a class="flex justify-between">Settings <x-fas-chevron-right class="w-4 h-4" /></a></li>
                                <li class="hover-bordered"><a class="flex justify-between">Logout <x-fas-chevron-right class="w-4 h-4" /></a></li>
                            </ul>
                        </div>
                        <div class="content col-span-3 p-4 min-h-full">
                        {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Scripts -->
        @livewireScripts
        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>

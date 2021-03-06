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
                                <li class="hover-bordered"><a href="{{ route('account.wishlist.index') }}" class="flex justify-between @if(request()->routeIs('account.wishlist.index')) active @endif">Wishlist <x-fas-chevron-right class="w-4 h-4" /></a></li>
                                <li class="hover-bordered"><a href="{{ route('account.settings.index') }}" class="flex justify-between @if(request()->routeIs('account.settings.index')) active @endif">Settings <x-fas-chevron-right class="w-4 h-4" /></a></li>
                                <li class="hover-bordered"><a class="flex justify-between">Logout <x-fas-chevron-right class="w-4 h-4" /></a></li>
                            </ul>

                            <div class="hidden sm:flex flex-col gap-4 px-4">
                                <a href="https://play.google.com/store/apps/details?id=com.loan.cash.credit.okash.nigeria&hl=en&gl=NG" target="_blank" rel="nofollow" class="">
                                    <img src="{{Storage::url('opay.jpeg')}}" class="object-cover rounded-lg" alt="OPay Load">
                                </a>

                                <a href="https://play.google.com/store/apps/details?id=com.transsnetfinancial.palmcredit" target="_blank" rel="nofollow" class="">
                                    <img src="{{Storage::url('palmcredit.jpeg')}}" class="object-cover rounded-lg" alt="Palmcredit Load">
                                </a>

                                <a href="https://fairmoney.app.link/referral?referral_code=47XFM" target="_blank" rel="nofollow" class="">
                                    <img src="{{Storage::url('fairmoney.jpeg')}}" class="object-cover rounded-lg" alt="Fairmoney Load">
                                </a>

                            </div>
                        </div>
                        <div class="content col-span-3 p-4 min-h-full">
                        {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>

            <footer class="bg-gray-100 text-center lg:text-left">
                <div class="text-gray-700 text-center p-4">
                  &copy; {{ date('Y') }} Copyright:
                  <a class="text-gray-800" href="{{ url('/')}}">{{ setting('site_name')}}</a>
                </div>
            </footer>

                @include('partials.whatsapp')
        </div>

        <!-- Scripts -->
        @livewireScripts
        {{-- @livewireChartsScripts --}}
        <script src="{{ asset('js/app.js') }}"></script>

        <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 5000,
                timerProgressBar:true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            window.addEventListener('alert',({detail:{type,message}})=>{
                Toast.fire({
                    icon:type,
                    title:message
                })
            })

            @if(session('success'))
                Toast.fire({
                    icon:'success',
                    title:'{{session("success")}}'
                })
            @endif

            @if($errors->any())
            @foreach ($errors->all() as $error)
            Toast.fire({
                    icon:'error',
                    title:'{{$error}}'
                })
            @endforeach
            @endif
        </script>
        @stack('scripts')
    </body>
</html>

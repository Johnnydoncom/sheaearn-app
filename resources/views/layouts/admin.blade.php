<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Neuton:wght@200;300;400;700&family=Open+Sans:wght@300;400;500;600;700&family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @livewireStyles
    @stack('styles')
</head>
<body class="font-sans antialiased" x-data="{ sidebarOpened: false, scrollAtTop:false}"
      @scroll.window="window.pageYOffset > 40 ? scrollAtTop = true: scrollAtTop= false">

<div x-data="{ menuOpen: false }" class="flex min-h-screen custom-scrollbar">

    <!-- start::Black overlay -->
    <div :class="menuOpen ? 'block' : 'hidden'" @click="menuOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
    <!-- end::Black overlay -->

    @include('partials.admin.sidebar')

    <div class="lg:pl-64 w-full flex flex-col">
    @include('partials.admin.header')

    <!-- start:Page content -->
        <div class="h-full bg-slate-100 p-4">
            {{ $slot }}
        </div>
        <!-- end:Page content -->
    </div>


</div>


@include('partials.loader')

<!-- Scripts -->
@livewireScripts
<script src="https://unpkg.com/@alpinejs/collapse@3.4.2/dist/cdn.min.js"></script>
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
</script>
@stack('scripts')
</body>
</html>

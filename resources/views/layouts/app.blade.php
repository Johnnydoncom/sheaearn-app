<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ (isset($title) ? $title : '') .' - ' .config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500&family=Poppins:ital,wght@0,100;0,300;0,400;0,600;0,700;0,800;0,900;1,200&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @livewireStyles

    </head>
    <body class="font-sans antialiased" >
        <div class="min-h-screen bg-white" x-data="{isLoggedIn: {{ Auth::check() ? 1 : 0 }}, showLoginModal:false }">
{{--            @include('partials.header')--}}
            @livewire('app-header', ['pageTitle' => isset($title) ? (string)$title : '', 'searchIcon' => isset($searchIcon) ? true : false ])


            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <template x-if="showLoginModal">
                <div class="modal modal-open">
                    <div class="modal-box relative max-w-xl text-center">
                        <label for="my-modal-3" class="btn btn-sm btn-circle absolute right-2 top-2" @click="showLoginModal=false">✕</label>
                        <div class="py-10">
                            <h3 class="text-2xl font-bold mb-10">Hey, 👋 sign up or sign in to interact.</h3>

                            <div class="flex w-full max-w-md mx-auto">
                                <div class="grid h-24 flex-grow card rounded-box place-items-center"><a href="{{route('login')}}" class="btn btn-primary w-full">Sign In</a></div>
                                <div class="divider divider-horizontal my-0">OR</div>
                                <div class="grid h-24 flex-grow card rounded-box place-items-center"> <a href="{{route('register')}}" class="btn btn-primary btn-block w-full">Sign Up</a></div>
                            </div>
                        </div>
                        <p class="py-4">You've been selected for a chance to get one year of subscription to use Wikipedia for free!</p>
                    </div>
                </div>
            </template>

            @include('partials.footer')
        </div>

        <!-- Scripts -->
        @livewireScripts
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

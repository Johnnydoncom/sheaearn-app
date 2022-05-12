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
<body class="font-sans antialiased">
<div class="min-h-screen bg-white dark:bg-black">
    @livewire('guest-header', ['pageTitle' => isset($title) ? (string)$title : '', 'searchIcon' => isset($searchIcon) ? true : false ])

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

<!-- Scripts -->
@livewireScripts
<script src="{{ asset('js/app.js') }}"></script>

<script>
    // var themeToggleDarkIcon = document.getElementById('dark-mode-toggle');
    var themeToggleBtn = document.getElementById('theme-toggle');

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleBtn.classList.remove('swap-active');
        document.documentElement.classList.add('dark');
    } else {
        themeToggleBtn.classList.add('swap-active');
        document.documentElement.classList.remove('dark');
    }


    themeToggleBtn.addEventListener('click', function() {

        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');

                themeToggleBtn.classList.remove('swap-active');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                themeToggleBtn.classList.add('swap-active');
            }

            // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                themeToggleBtn.classList.remove('swap-active');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                themeToggleBtn.classList.add('swap-active');
            }
        }

    });
</script>
</body>
</html>

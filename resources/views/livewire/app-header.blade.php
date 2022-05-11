@if((new \Jenssegers\Agent\Agent())->isMobile())
    <span class="sticky top-0 z-50">
    <nav x-data="{ open: false }" aria-label="Mobile Menu" class="lg:hidden bg-white relative">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-2 sticky top-0">
            <div class="flex justify-between gap-4 items-center h-16">
                <div class="flex justify-between truncate">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        @if(isset($pageTitle) && $pageTitle)
                            <h2 class="font-bold text-xl">{{ $pageTitle }}</h2>
                        @else
                            <a href="{{ route('index') }}">
                                <x-application-logo class="block h-8 w-auto fill-current text-gray-600" />
                            </a>
                        @endif
                    </div>
                </div>

                <div class="hiddenn lg:flex lg:items-center lg:ml-6">
                    @auth
                        <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('header.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    @else

                        &nbsp; &nbsp;
                    @endauth
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center lg:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Hamburger -->
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="z-50 hidden md:hidden fixed top-0 right-auto min-h-screen h-screen left-0 w-11/12 overflow-y-scroll">

            <div class="bg-black opacity-30 fixed inset-0" @click="open = false"></div>

            <div class="bg-white shadow-xl w-full max-w-xs h-full z-10 absolute">
                <div class="px-4 pt-5 pb-2 bg-primary text-white">
                    <div class="flex justify-end">
                        <button type="button" class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-white" @click="open = false">
                            <span class="sr-only">Close menu</span>
                            <span class="fa fa-close h-6 w-6" aria-hidden="true"></span>
                        </button>
                    </div>
                    <h2 class="font-bold text-lg mb-2">Welcome to {{ setting('site_name') }}</h2>
                   <p class="font-semibold text-sm text-gray-200 mb-2">Wholesale trading without limits</p>
                </div>

                 <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('index')" :active="request()->routeIs('index')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
            </div>

                <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    @auth
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>

                    @else

                    @endauth
                </div>

                @auth
                    <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('header.logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
                @endauth
            </div>
        </div>
        </div>
    </nav>
</span>
@else
    <span class="stickyy top-0">

    <div aria-label="Above" class="bg-primary text-sm font-medium text-white z-20">
        <div class="container p-6">
            <div class="flex items-center sm:justify-between">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('index') }}">
                        <x-application-logo class="block h-16 w-auto fill-current text-gray-600" type="light" />
                    </a>
                </div>

                <div class="navbar-end ml-auto text-right">
                    <button class="btn btn-ghost btn-circle h-14 w-14">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                    <button class="btn btn-ghost btn-circle h-14 w-14">
                      <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                        <span class="badge badge-xs badge-primary indicator-item"></span>
                      </div>
                    </button>
                </div>

            </div>
        </div>
    </div>


    <nav x-data="{ open: false }" aria-label="Primary Menu" class="bg-primary border-t border-white text-white relative w-full flex flex-wrap items-center justify-start py-1 text-white hover:text-gray-100 focus:text-gray-100 shadow-lg navbarr navbar-expand-lg navbar-dark">
        <!-- Primary Navigation Menu -->
        <div class="container sticky top-0">
            <div class="flex justify-between items-center">
                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-400 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <ul class="navbar-nav hidden sm:flex flex-col pl-0 list-style-none mr-auto">
                    @foreach($menu_topics as $mtopic)
                    <li class="nav-item p-1.5">
                      <a class="nav-link text-white hover:text-gray-100 focus:text-gray-100 p-2 pt-2 pb-2 hover:border-b-4 hover:border-white" href="#">{{ __($mtopic->name) }}</a>
                    </li>
                    @endforeach
                </ul>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-auto sm:justify-start">
                    @auth
                        <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-white hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    @else

                    @endauth
                </div>

                <div class="social-icons flex gap-2 items-center">
                    <ul class="menu menu-horizontal">
                        <li><a href="#"> <x-cui-cib-facebook class="w-5 h-5"/></a></li>
                         <li><a href="#"> <x-cui-cib-twitter class="w-5 h-5"/></a></li>
                        <li><a href="#"> <x-cui-cib-whatsapp class="w-5 h-5"/></a></li>
                    </ul>
                </div>


            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="z-50 hidden sm:hidden fixed top-0 right-auto min-h-screen h-screen left-0 w-11/12 overflow-y-scroll">

            <div class="bg-black opacity-30 fixed inset-0" @click="open = false"></div>

            <div class="bg-white shadow-xl w-full max-w-xs h-full z-10 absolute">
                <div class="px-4 pt-5 pb-2 bg-primary text-white">
                    <div class="flex justify-end">
                        <button type="button" class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-white" @click="open = false">
                            <span class="sr-only">Close menu</span>
                            <span class="fa fa-close h-6 w-6" aria-hidden="true"></span>
                        </button>
                    </div>
                    <h2 class="font-bold text-lg mb-2">Welcome to {{ setting('site_name') }}</h2>
                   <p class="font-semibold text-sm text-gray-200 mb-2">Wholesale trading without limits</p>
                </div>

                 <div class="pt-2 pb-3 space-y-1">
                     @auth
                         <x-responsive-nav-link :href="route('index')" :active="request()->routeIs('index')">
                        {{ __('My Account') }}
                    </x-responsive-nav-link>
                     @else

                     @endauth
            </div>

                <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    @auth
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>

                    @else

                    @endauth
                </div>

                @auth
                    <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
                @endauth
            </div>

            </div>




        </div>
    </nav>

    </span>
@endif

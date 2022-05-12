@if(1>3)
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



        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('index')" :active="request()->routeIs('index')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>

                    <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

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

        <!-- Responsive Navigation Menu -->
        <div :class="{'blockk': open, 'hidden': ! open}" class="z-50 hidden md:hidden fixed top-0 right-auto min-h-screen h-screen left-0 w-11/12 overflow-y-scroll">

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
    <span class="sticky sm:relative top-0 z-50">


    <nav x-data="{ open: false }" aria-label="Primary Menu" class="bg-white dark:bg-black w-full flex flex-wrap items-center justify-between py-1 navbar navbar-expand-lg navbar-light">
        <!-- Primary Navigation Menu -->
        <div class="sm:container inline-block sticky top-0 px-0 w-full">
            <div class="navbar">
                <div class="navbar-start">
                    <a href="{{ route('index') }}" class="py-2 sm:py-4">
                        <x-application-logo class="block h-10 sm:h-20 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <div class="mx-auto w-20 navbar-center justify-content-center justify-center">
                    <button class="swap swap-rotate" id="theme-toggle">

                          <!-- this hidden checkbox controls the state -->
{{--                          <input type="checkbox" class="hidden" id="theme-toggle" />--}}

                        <!-- sun icon -->
                          <svg class="swap-on fill-current w-6 h-6 sm:w-10 sm:h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>

                                                <!-- moon icon -->
                          <svg id="theme-toggle-dark-icon" class="swap-off fill-current w-6 h-6 sm:w-10 sm:h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>

                    </button>
                </div>


                <div class="navbar-end">


                    <ul class="hidden sm:flex menu menu-horizontal ml-auto flex-none gap-2">
{{--                    @foreach($menu_topics as $mtopic)--}}
                        {{--                    <li class="nav-item p-1.5">--}}
                        {{--                      <a class="nav-link text-black hover:text-primary focus:text-primary text-xl p-2 pt-2 pb-2 hover:border-b-4 hover:border-white" href="#">{{ __($mtopic->name) }}</a>--}}
                        {{--                    </li>--}}
                        {{--                    @endforeach--}}


                    <li class="nav-item p-1.5">
                      <a class="nav-link text-gray-900 hover:text-primary focus:text-primary text-2xl font-medium" href="#">{{ __('About') }}</a>
                    </li>
                    <li class="nav-item p-1.5">
                      <a class="nav-link text-gray-900 hover:text-primary focus:text-primary text-2xl font-medium" href="{{ route('blog.index') }}">{{ __('Blog') }}</a>
                    </li>
                    <li class="nav-item p-1.5">
                      <a class="nav-link text-gray-900 hover:text-primary focus:text-primary text-2xl font-medium" href="#">{{ __('Join') }}</a>
                    </li>
                    <li class="nav-item p-1.5">
                      <a class="nav-link text-gray-900 hover:text-primary focus:text-primary text-2xl font-medium " href="#">{{ __('Community') }}</a>
                    </li>
                </ul>


                    <!-- Hamburger -->
                     <div class="flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md hover:text-primary hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                    <!-- Hamburger -->
                </div>
            </div>

            <div :class="{'inline-block': open, 'hidden': ! open}" class="hidden sm:hidden container w-full sticky top-0">
                <ul class="menu bg-base-100 w-full min-w-full p-2 rounded-box">
                   <li class="">
                      <a class="" href="#">{{ __('About') }}</a>
                    </li>
                    <li class="">
                      <a class="" href="{{ route('blog.index') }}">{{ __('Blog') }}</a>
                    </li>
                    <li class="">
                      <a class="" href="#">{{ __('Join') }}</a>
                    </li>
                    <li class="">
                      <a class="" href="#">{{ __('Community') }}</a>
                    </li>
                </ul>
            </div>
        </div>


    </nav>

    </span>
@endif

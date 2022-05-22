<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('index') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('account.index')" :active="request()->routeIs('account.index')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div> --}}
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
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
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden" :class="{'block': ! open, 'hidden': open}">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>



    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="z-50 hidden sm:hidden fixed top-0 right-auto min-h-screen h-screen left-0 w-11/12 overflow-y-scroll">

        <div class="bg-black opacity-30 fixed inset-0" @click="open = false"></div>

        <div class="bg-white shadow-xl w-full max-w-xs h-full z-10 absolute">
            <div class="px-4 pt-5 pb-2 bg-primary text-white relative">
                <div class="flex justify-end absolute top-1 right-2">
                    <button type="button" class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-white" @click="open = false">
                        <span class="sr-only">Close menu</span>
                        <span class="fa fa-close h-6 w-6" aria-hidden="true"></span>
                        <x-cui-cil-x class="h-6 w-6" aria-hidden="true" />
                    </button>
                </div>
                <div class="avatar">
                    <div class="w-14 mask mask-hexagon">
                        <img src="{{ Auth::user()->avatar_url }}" />
                    </div>
                </div>
                <h2 class="font-bold text-lg mb-0">{{ Auth::user()->name }}</h2>
{{--                <p class="font-semibold text-sm text-gray-200 mb-2">{{ Auth::user()->email }}</p>--}}
            </div>

            <div class="pt-2 pb-3 space-y-1">
                @auth
                    <ul class="menu">
                        <li class="hover-bordered"><a href="{{ route('account.index') }}" class="flex justify-between items-center @if(request()->routeIs('account.index')) active @endif">Home <x-fas-chevron-right class="w-4 h-4" /></a></li>
                        <li class="hover-bordered"><a href="{{ route('account.order.index') }}" class="flex justify-between items-center @if(request()->routeIs('account.order.index')) active @endif">Orders <x-fas-chevron-right class="w-4 h-4" /></a></li>
                        <li class="hover-bordered"><a href="{{ route('account.transactions.index') }}" class="flex justify-between items-center @if(request()->routeIs('account.transactions.index')) active @endif">Transactions <x-fas-chevron-right class="w-4 h-4" /></a></li>
                        <li class="hover-bordered"><a class="flex justify-between items-center">Wishlist <x-fas-chevron-right class="w-4 h-4" /></a></li>
                        <li class="hover-bordered"><a class="flex justify-between items-center">Settings <x-fas-chevron-right class="w-4 h-4" /></a></li>
                        <li class="hover-bordered">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf

                                <a class="flex justify-between w-full items-center" href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout <x-fas-chevron-right class="w-4 h-4" />
                                </a>
                            </form>
{{--                            <a class="flex justify-between">Logout <x-fas-chevron-right class="w-4 h-4" /></a>--}}
                        </li>
                    </ul>

                @else

                @endauth
            </div>


        </div>

    </div>

</nav>

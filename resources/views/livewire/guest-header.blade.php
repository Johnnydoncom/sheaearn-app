<div class="sticky sm:relative top-0 z-50">
        <nav x-data="{ open: false }" aria-label="Primary Menu" class="bg-white dark:bg-black w-full flex flex-wrap items-center justify-between py-1 navbar navbar-expand-lg navbar-light">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto inline-block sticky top-0 px-0 w-full">
                <div class="navbar navbar-expand-lg navbar-light relative w-full py-2">
                    <div class="navbar-start">
                        <a href="{{ route('index') }}" class="py-0 sm:py-0">
                            <x-application-logo class="block h-10 sm:h-20 w-auto fill-current text-gray-600" />
                        </a>
                    </div>

                    <div class="navbar-center">
                        <div class="inline-block w-auto space-x-4 items-center bg-slate-100 dark:bg-indigo-400/50 rounded-full p-1">
                            <button class="p-1" id="light-mode-switch">
                                <svg id="dark-mode-toggle" class="swap-on fill-current w-6 h-6 sm:w-8 sm:h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>
                            </button>

                            <button class="theme-active p-1" id="dark-mode-switch">
                                <!-- moon icon -->
                                <svg id="light-mode-toggle" class="swap-off fill-current w-6 h-6 sm:w-8 sm:h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
                            </button>
                        </div>

                        @if(1>2)
                            <button class="dark:text-gray-200" id="theme-toggle">
                                <!-- sun icon -->
                                <svg id="dark-mode-toggle" class="swap-on fill-current w-6 h-6 sm:w-10 sm:h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>

                                <!-- moon icon -->
                                <svg id="light-mode-toggle" class="swap-off fill-current w-6 h-6 sm:w-10 sm:h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>

                            </button>
                        @endif
                    </div>


                    <div class="navbar-end">

                        <ul class="hidden sm:flex menu menu-horizontal">

                            <li class="">
                                <a class="text-gray-900 dark:text-gray-200 hover:text-primary dark:hover:text-primary hover:bg-transparent focus:text-primary text-xl font-medium" href="#">{{ __('About') }}</a>
                            </li>
                            <li class="">
                                <a class="text-gray-900 dark:text-gray-200 hover:text-primary dark:hover:text-primary hover:bg-transparent focus:text-primary text-xl font-medium" href="{{ route('blog.index') }}">{{ __('Blog') }}</a>
                            </li>
                            <li class="">
                                <a class="text-gray-900 dark:text-gray-200 hover:text-primary dark:hover:text-primary hover:bg-transparent focus:text-primary text-xl font-medium" href="#">{{ __('Join') }}</a>
                            </li>
                            <li class="">
                                <a class="text-gray-900 dark:text-gray-200 hover:text-primary dark:hover:text-primary hover:bg-transparent focus:text-primary text-xl font-medium " href="#">{{ __('Community') }}</a>
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
    </div>

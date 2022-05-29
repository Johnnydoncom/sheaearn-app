<aside
id="aside"
                :class="menuOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
                class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 bg-secondary overflow-y-auto lg:translate-x-0 lg:inset-0 custom-scrollbar"
            >
                <!-- start::Logo -->
                <div class="flex items-center justify-center bg-black bg-opacity-30 h-16">
                    <h1 class="text-gray-100 text-lg font-bold uppercase tracking-widest">
                        Sheaearn
                    </h1>
                </div>
                <!-- end::Logo -->

                <!-- start::Navigation -->
                <nav class="py-4 custom-scrollbar" id="asidee">
                    <!-- start::Menu link -->
                    <a
                        x-data="{ linkHover: false }"
                        @mouseover = "linkHover = true"
                        @mouseleave = "linkHover = false"
                        href="{{ route('admin.index') }}"
                        class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class="linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="ml-3 transition duration-200" :class="linkHover ? 'text-gray-100' : ''">
                            Dashboard
                        </span>
                    </a>
                    <!-- end::Menu link -->

                    @hasanyrole(\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)
                    <!-- start::Menu link -->
                    <div x-data="{ linkHover: false, linkActive: false }">
                        <div @mouseover = "linkHover = true" @mouseleave = "linkHover = false" @click = "linkActive = !linkActive" class="flex items-center justify-between text-gray-400 hover:text-gray-100 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200" :class=" linkActive ? 'bg-black bg-opacity-30 text-gray-100' : ''">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class=" linkHover || linkActive ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <span class="ml-3">Posts</span>
                            </div>
                            <svg class="w-3 h-3 transition duration-300" :class="linkActive ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                        <!-- start::Submenu -->
                        <ul x-show="linkActive" x-cloak x-collapse.duration.300ms class="text-gray-400">
                            <!-- start::Submenu link -->
                            <li class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                                <a href="{{ route('admin.entries.index') }}" class="flex items-center">
                                    <span class="mr-2 text-sm">&bull;</span>
                                    <span class="overflow-ellipsis">All Posts</span>
                                </a>
                            </li>
                            <!-- end::Submenu link -->

                            <!-- start::Submenu link -->
                            <li class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                                <a href="{{ route('admin.entries.create') }}" class="flex items-center">
                                    <span class="mr-2 text-sm">&bull;</span>
                                    <span class="overflow-ellipsis">Add New</span>
                                </a>
                            </li>
                            <!-- end::Submenu link -->

                            <!-- start::Submenu link -->
                            <li class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                                <a href="{{ route('admin.topics.index') }}" class="flex items-center">
                                    <span class="mr-2 text-sm">&bull;</span>
                                    <span class="overflow-ellipsis">Categories</span>
                                </a>
                            </li>
                            <!-- end::Submenu link -->
                        </ul>
                        <!-- end::Submenu -->
                    </div>
                    <!-- end::Menu link -->
                    @endhasanyrole

                    @hasanyrole(\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)
                    <!-- start::Menu link -->
                    <div x-data="{ linkHover: false, linkActive: false }">
                        <div @mouseover = "linkHover = true" @mouseleave = "linkHover = false" @click = "linkActive = !linkActive" class="flex items-center justify-between text-gray-400 hover:text-gray-100 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200" :class=" linkActive ? 'bg-black bg-opacity-30 text-gray-100' : ''">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class=" linkHover || linkActive ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <span class="ml-3">Ads</span>
                            </div>
                            <svg class="w-3 h-3 transition duration-300" :class="linkActive ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                        <!-- start::Submenu -->
                        <ul x-show="linkActive" x-cloak x-collapse.duration.300ms class="text-gray-400">
                            <li class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                                <a href="{{ route('admin.ads.index') }}" class="flex items-center">
                                    <span class="mr-2 text-sm">&bull;</span>
                                    <span class="overflow-ellipsis">All Ads</span>
                                </a>
                            </li>
                            <li class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                                <a href="{{ route('admin.ads.create') }}" class="flex items-center">
                                    <span class="mr-2 text-sm">&bull;</span>
                                    <span class="overflow-ellipsis">Add New</span>
                                </a>
                            </li>
                        </ul>
                        <!-- end::Submenu -->
                    </div>
                    <!-- end::Menu link -->
                    @endhasanyrole

                    <!-- start::product link -->
                    <div x-data="{ linkHover: false, linkActive: false }">
                        <div @mouseover = "linkHover = true" @mouseleave = "linkHover = false" @click = "linkActive = !linkActive" class="flex items-center justify-between text-gray-400 hover:text-gray-100 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200" :class=" linkActive ? 'bg-black bg-opacity-30 text-gray-100' : ''">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class=" linkHover || linkActive ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <span class="ml-3">Products</span>
                            </div>
                            <svg class="w-3 h-3 transition duration-300" :class="linkActive ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                        <!-- start::Submenu -->
                        <ul x-show="linkActive" x-cloak x-collapse.duration.300ms class="text-gray-400">
                            <!-- start::Submenu link -->
                            <li class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                                <a href="{{ route('admin.products.index') }}" class="flex items-center">
                                    <span class="mr-2 text-sm">&bull;</span>
                                    <span class="overflow-ellipsis">All Products</span>
                                </a>
                            </li>
                            <!-- end::Submenu link -->

                            <!-- start::Submenu link -->
                            <li class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                                <a href="{{ route('admin.products.create') }}" class="flex items-center">
                                    <span class="mr-2 text-sm">&bull;</span>
                                    <span class="overflow-ellipsis">Add New</span>
                                </a>
                            </li>
                            <!-- end::Submenu link -->

                            <!-- start::Submenu link -->
                            <li class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                                <a href="{{ route('admin.categories.index') }}" class="flex items-center">
                                    <span class="mr-2 text-sm">&bull;</span>
                                    <span class="overflow-ellipsis">Categories</span>
                                </a>
                            </li>
                            <!-- end::Submenu link -->
                        </ul>
                        <!-- end::Submenu -->
                    </div>
                    <!-- end::Menu link -->

                    <!-- start::product link -->
                    <a
                        x-data="{ linkHover: false }"
                        @mouseover = "linkHover = true"
                        @mouseleave = "linkHover = false"
                        href="{{ route('admin.orders.index') }}"
                        class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span
                            class="ml-3 transition duration-200"
                            :class="linkHover ? 'text-gray-100' : ''"
                        >
                            Orders
                        </span>
                    </a>
                    <!-- end::Menu link -->

                    <!-- start::withdraw link -->
                    @hasanyrole(\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)
                    <a
                        x-data="{ linkHover: false }"
                        @mouseover = "linkHover = true"
                        @mouseleave = "linkHover = false"
                        href="{{ route('admin.withdraw.index') }}"
                        class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span
                            class="ml-3 transition duration-200"
                            :class="linkHover ? 'text-gray-100' : ''"
                        >
                            Withdrawal
                        </span>
                    </a>
                    @endhasanyrole

                    @hasanyrole(\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)
                    <p class="text-xs text-gray-600 mt-6 mb-2 px-6 uppercase">User Management</p>
                    <!-- start::Menu link -->
                    <a
                        x-data="{ linkHover: false }"
                        @mouseover = "linkHover = true"
                        @mouseleave = "linkHover = false"
                        href="{{ route('admin.users.index') }}"
                        class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span
                            class="ml-3 transition duration-200"
                            :class="linkHover ? 'text-gray-100' : ''"
                        >
                            All Users
                        </span>
                    </a>
                    <!-- end::Menu link -->

                    <!-- start::Menu link -->
                    <a
                        x-data="{ linkHover: false }"
                        @mouseover = "linkHover = true"
                        @mouseleave = "linkHover = false"
                        href="{{ route('admin.users.create') }}"
                        class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
                    >
                        <svg class="w-5 h-5 transition duration-200" :class=" linkHover ? 'text-gray-100' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span
                            class="ml-3 transition duration-200"
                            :class="linkHover ? 'text-gray-100' : ''">
                            Add User
                        </span>
                    </a>
                    <!-- end::Menu link -->
                    @endhasanyrole

                    @hasanyrole(\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)
                    <p class="text-xs text-gray-600 mt-6 mb-2 px-6 uppercase">Settings</p>
                    <!-- start::Menu link -->
                    <a
                        x-data="{ linkHover: false }"
                        @mouseover = "linkHover = true"
                        @mouseleave = "linkHover = false"
                        href="{{ route('admin.settings.index') }}"
                        class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span
                            class="ml-3 transition duration-200"
                            :class="linkHover ? 'text-gray-100' : ''"
                        >
                            General Settings
                        </span>
                    </a>
                    <!-- end::Menu link -->

                    <!-- start::Menu link -->
                    <a
                        x-data="{ linkHover: false }"
                        @mouseover = "linkHover = true"
                        @mouseleave = "linkHover = false"
                        href="{{ route('admin.settings.shop') }}"
                        class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span
                            class="ml-3 transition duration-200"
                            :class="linkHover ? 'text-gray-100' : ''"
                        >
                            Store Settings
                        </span>
                    </a>

                    <a
                        x-data="{ linkHover: false }"
                        @mouseover = "linkHover = true"
                        @mouseleave = "linkHover = false"
                        href="{{ route('admin.settings.blog') }}"
                        class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200" :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span
                            class="ml-3 transition duration-200"
                            :class="linkHover ? 'text-gray-100' : ''"
                        >
                            Blog Settings
                        </span>
                    </a>
                    @endhasanyrole
                </nav>
                <!-- end::Navigation -->
            </aside>


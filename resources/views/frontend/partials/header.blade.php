<header class="bg-white dark:bg-gray-900 fixed top-0 z-50 w-full shadow-md">
    <div class="max-w-screen px-3">
        <div class="flex h-16 items-center justify-between">
            <div class="flex-1 md:flex md:items-center md:gap-12">
                <a class="block text-teal-600 dark:text-teal-300" href="{{ url('/') }}">
                    <span>LARABRIX SHOP</span>
                </a>
            </div>
            <!-- Navbar Center: Search -->
            <div class="navbar-center hidden lg:flex w-full max-w-xl absolute left-1/2 transform -translate-x-1/2">
                <form action="{{ route('frontend.products.index') }}" method="GET" class="w-full relative">
                    <label class="input w-full relative p-0">
                        {{-- <svg class="h-[1em] opacity-50 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
          </g>
        </svg> --}}
                        <input type="search" name="q" required placeholder="Search products..."
                            class="w-full px-4 rounded border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 dark:text-black"
                            value="{{ request()->get('q') }}">
                    </label>
                </form>
            </div>
            <div x-cloak x-data="{ isMenuOpen: false, isCartOpen: false }" class="md:flex md:items-center md:gap-12">
                <nav aria-label="Global" class="md:block hidden w-full md:w-auto mt-4 md:mt-0">
                    {{-- @php
                        $menu = \App\Models\Menu::with('childrenRecursive')->where('type', 'header')->get();
                    @endphp --}}

                    <ul class="flex items-center gap-4 text-sm">
                        {{-- @include('frontend.partials.menu-item', ['items' => $menu]) --}}
                        <a href="{{ route('frontend.products.index') }}"
                            class="text-gray-500 transition hover:text-gray-500/75 dark:text-white dark:hover:text-white/75">
                            Products
                        </a>
                        <a href="{{ route('frontend.pc_builder') }}"
                            class="text-gray-500 transition hover:text-gray-500/75 dark:text-white dark:hover:text-white/75">
                            PC Builder
                        </a>
                        @auth
                            <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('user.login') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                Log in
                            </a>
                        @endauth

                        <div x-data="{ isCartOpen: false }" x-transition x-cloak class="relative">
                            <!-- 🛍️ Cart Button -->
                            <button type="button" @click="isCartOpen = true"
                                class="relative text-gray-500 transition hover:text-gray-500/75 dark:text-white dark:hover:text-white/75 cursor-pointer">

                                <!-- Cart Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-4">
                                    <path fill-rule="evenodd"
                                        d="M6 5v1H4.667a1.75 1.75 0 0 0-1.743 1.598l-.826 9.5A1.75 1.75 0 0 0 3.84 19H16.16a1.75 1.75 0 0 0 1.743-1.902l-.826-9.5A1.75 1.75 0 0 0 15.333 6H14V5a4 4 0 0 0-8 0Zm4-2.5A2.5 2.5 0 0 0 7.5 5v1h5V5A2.5 2.5 0 0 0 10 2.5ZM7.5 10a2.5 2.5 0 0 0 5 0V8.75a.75.75 0 0 1 1.5 0V10a4 4 0 0 1-8 0V8.75a.75.75 0 0 1 1.5 0V10Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <!-- Counter badge -->
                                <span x-show="Object.keys($store.cart.items).length > 0"
                                    x-text="Object.keys($store.cart.items).length"
                                    class="absolute -top-2 -right-2 inline-flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[10px] text-white"></span>
                            </button>

                            <!-- 🛒 Cart Drawer -->
                            <div x-show="isCartOpen" x-transition:enter="transform transition ease-in-out duration-300"
                                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-300"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                class="fixed right-0 top-0 z-50 h-full w-full max-w-sm overflow-y-auto border border-gray-600 bg-gray-100 px-4 py-8 shadow-lg sm:px-6 lg:px-8"
                                aria-modal="true" role="dialog" tabindex="-1" @click.outside="isCartOpen = false">

                                <!-- ❌ Close Button -->
                                <button @click="isCartOpen = false"
                                    class="absolute end-4 top-4 text-gray-600 transition hover:scale-110 cursor-pointer">
                                    <span class="sr-only">Close cart</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <!-- 👉 Your cart content here -->
                                @include('frontend.carts.sidebar')
                            </div>
                        </div>
                    </ul>
                </nav>

                <div class="flex items-center gap-4">
                    <div class="block md:hidden">
                        <button @click="isMenuOpen = !isMenuOpen"
                            class="rounded-sm bg-gray-100 p-2 text-gray-600 transition hover:text-gray-600/75 dark:bg-gray-800 dark:text-white dark:hover:text-white/75">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div role="menu" :class="{ 'block': isMenuOpen, 'hidden': !isMenuOpen }"
                    class="absolute end-0 top-15 z-1 w-full overflow-hidden rounded border border-gray-300 bg-white shadow-sm">

                    @auth
                        <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                            class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                            role="menuitem">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('user.login') }}"
                            class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                            role="menuitem">
                            Login
                        </a>
                    @endauth

                    <a href="{{ route('frontend.products.index') }}"
                        class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                        role="menuitem">
                        Products
                    </a>

                    <div x-data="{ isCartOpen: false }" x-transition x-cloak class="relative w-full">
                        <!-- 🛍️ Cart Button -->
                        <button type="button" @click="isCartOpen = true"
                            class="cursor-pointer text-left w-full block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900">

                            Cart
                        </button>

                        <!-- 🛒 Cart Drawer -->
                        <div x-show="isCartOpen" x-transition
                            class="fixed right-0 top-0 z-50 h-full w-full max-w-sm overflow-y-auto border border-gray-600 bg-gray-100 px-4 py-8 shadow-lg sm:px-6 lg:px-8"
                            aria-modal="true" role="dialog" tabindex="-1" @click.outside="isCartOpen = false">

                            <!-- ❌ Close Button -->
                            <button @click="isCartOpen = false"
                                class="absolute end-4 top-4 text-gray-600 transition hover:scale-110 cursor-pointer">
                                <span class="sr-only">Close cart</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- 👉 Your cart content here -->
                            @include('frontend.carts.sidebar')

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

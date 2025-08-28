<nav class="bg-gray-800 text-white mt-16 fixed top-0 z-40 w-full shadow-md" x-data="{ mobileOpen: false }">
    <div class="max-w-screen-xl px-3">
        <div class="flex items-center justify-between py-3 md:py-0">
            {{-- Mobile Hamburger --}}
            <button @click="mobileOpen = !mobileOpen" class="md:hidden focus:outline-none flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path x-show="!mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>Categories</span>
            </button>
        </div>

        {{-- Desktop Horizontal Menu --}}
        <div class="hidden md:flex md:items-center md:space-x-6">
            <ul class="flex space-x-4">
                @include('frontend.partials.category-item', ['parentId' => null, 'childrenMap' => $childrenMap, 'level' =>0])
            </ul>
        </div>

        {{-- Mobile Vertical Menu (HyperUI style) --}}
        <div x-show="mobileOpen" x-transition class="md:hidden mt-2 border-t border-gray-700">
        <nav class="space-y-1 py-2">
            @include('frontend.partials.mobile-category-item', ['parentId' => null, 'childrenMap' => $childrenMap])
        </nav>
    </div>
    </div>
</nav>
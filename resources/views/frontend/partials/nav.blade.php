@php $categories = \App\Models\Category::whereNull('parent_id')->with('childrenRecursive')->get() @endphp
    <nav class="bg-gray-800 text-white" x-data="{ mobileOpen: false }">
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
                    @include('frontend.partials.category-item', ['categories' => $categories])
                </ul>
            </div>

            {{-- Mobile Vertical Menu (HyperUI style) --}}
            <div x-show="mobileOpen" x-transition class="md:hidden mt-2 border-t border-gray-700">
                <nav class="space-y-1">
                    @foreach ($categories as $item)
                        <details class="group [&_summary::-webkit-details-marker]:hidden">
                            <summary
                                class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-700">
                                <span>{{ $item->title }}</span>
                                @if ($item->childrenRecursive->isNotEmpty())
                                    <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                @endif
                            </summary>

                            @if ($item->childrenRecursive->isNotEmpty())
                                <nav class="mt-1.5 ml-4 flex flex-col border-l border-gray-700 pl-2">
                                    @foreach ($item->childrenRecursive as $child)
                                        @if ($child->childrenRecursive->isNotEmpty())
                                            {{-- Recursive call for nested --}}
                                            @include('frontend.partials.mobile-category-item', [
                                                'categories' => [$child],
                                            ])
                                        @else
                                            <a href=""
                                                class="rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-600">
                                                {{ $child->title }}
                                            </a>
                                        @endif
                                    @endforeach
                                </nav>
                            @endif
                        </details>
                    @endforeach
                </nav>
            </div>
        </div>
    </nav>
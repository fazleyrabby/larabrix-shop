@isset($childrenMap[$parentId])
    @foreach ($childrenMap[$parentId] as $item)
        @if(isset($childrenMap[$item->id]))
            <!-- Item has children: use details/summary -->
            <details x-data="{ open: false }" :open="open" class="group [&_summary::-webkit-details-marker]:hidden">
                <summary
                    @click.prevent="open = !open"
                    class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-700">
                    <span>{{ $item->title }}</span>
                    <span class="shrink-0 transition-transform duration-300 transform" :class="{ 'rotate-180': open }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </summary>

                <nav class="mt-1.5 ml-4 flex flex-col border-l border-gray-700 pl-2">
                    @include('frontend.partials.mobile-category-item', ['parentId' => $item->id, 'childrenMap' => $childrenMap])
                </nav>
            </details>
        @else
            <!-- Leaf item: just a link -->
            <a href="#"
               class="rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-600">
                {{ $item->title }}
            </a>
        @endif
    @endforeach
@endisset
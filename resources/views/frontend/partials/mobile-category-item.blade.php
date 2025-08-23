@foreach ($categories as $item)
    <details class="group [&_summary::-webkit-details-marker]:hidden">
        <summary
            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-700">
            <span>{{ $item->title }}</span>
            @if($item->childrenRecursive->isNotEmpty())
                <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            @endif
        </summary>

        @if($item->childrenRecursive->isNotEmpty())
            <nav class="mt-1.5 ml-4 flex flex-col border-l border-gray-700 pl-2">
                @foreach ($item->childrenRecursive as $child)
                    @if($child->childrenRecursive->isNotEmpty())
                        @include('frontend.partials.mobile-category-item', ['categories' => [$child]])
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
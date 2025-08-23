@foreach ($categories as $item)
    <li x-data="{ open: false }" class="relative">
        {{-- Parent as toggle only --}}
        <button @click="open = !open"
                class="flex items-center justify-between py-3 px-2 w-full text-left hover:text-gray-300">
            <span>{{ $item->title }}</span>
            @if($item->childrenRecursive->isNotEmpty())
                <svg class="w-4 h-4 ml-1 transform transition-transform duration-200"
                     :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            @endif
        </button>

        {{-- Dropdown --}}
        @if ($item->childrenRecursive->isNotEmpty())
            <ul x-show="open" @click.outside="open = false"
                x-transition
                class="md:absolute md:left-0 md:w-48 md:bg-gray-700 md:rounded md:shadow-lg 
                       md:z-50 flex flex-col md:mt-0 mt-1 md:space-y-0 space-y-1 md:pl-0 pl-4">
                @foreach ($item->childrenRecursive as $child)
                    <li>
                        @if($child->childrenRecursive->isNotEmpty())
                            @include('frontend.partials.category-item', ['categories' => [$child]])
                        @else
                            <a href=""
                               class="block px-4 py-2 hover:bg-gray-600">
                                {{ $child->title }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach
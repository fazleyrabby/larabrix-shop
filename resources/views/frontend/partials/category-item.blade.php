@isset($childrenMap[$parentId])
    @foreach ($childrenMap[$parentId] as $item)
        <li x-data="{ open: false }" x-cloak class="relative">
            {{-- Parent as toggle --}}
            <button @click="open = !open"
                    class="flex items-center justify-between py-3 px-2 w-full text-left hover:text-gray-300">
                @if($parentId)
                    <a href="{{ route('frontend.categories.show', $item->slug )}}">{{ $item->title }}</a>
                @else 
                    <span>{{ $item->title }}</span>
                @endif
                @if(isset($childrenMap[$item->id]))
                    <svg class="w-4 h-4 ml-1 transform transition-transform duration-200"
                         :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                @endif
            </button>

            {{-- Dropdown --}}
            @if(isset($childrenMap[$item->id]))
                <ul x-show="open" @click.outside="open = false"
                    x-transition
                    class="md:absolute md:left-0 md:w-48 md:rounded md:shadow-lg 
                           md:z-50 flex flex-col md:mt-0 mt-1 md:space-y-0 space-y-1 md:pl-0 pl-4 ml-4
                           {{ ['bg-gray-700','bg-gray-600','bg-gray-500','bg-gray-400'][$level % 4] ?? 'bg-gray-700' }}
                           ">
                    @include('frontend.partials.category-item', ['parentId' => $item->id, 'childrenMap' => $childrenMap, 'level' => $level+1])
                </ul>
            @endif
        </li>
    @endforeach
@endisset


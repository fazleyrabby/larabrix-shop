@foreach ($categories as $item)
    <li x-data="{ open: false }" class="relative">
        {{-- Parent as toggle only --}}
        <button @click="open = !open"
                class="flex items-center py-4 px-2 hover:text-gray-300 w-full text-left">
            <span>{{ $item->title }}</span>
            @if($item->childrenRecursive->isNotEmpty())
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            @endif
        </button>

        {{-- Dropdown --}}
        @if ($item->childrenRecursive->isNotEmpty())
            <ul x-show="open"
                @click.outside="open = false"
                x-transition
                class="absolute left-2 w-48 bg-gray-700 text-white rounded shadow-lg z-50">
                @foreach ($item->childrenRecursive as $child)
                    <li>
                        @if($child->childrenRecursive->isNotEmpty())
                            {{-- Recursive include for deeper levels --}}
                            @include('frontend.partials.category-item', ['categories' => [$child]])
                        @else
                            {{-- Normal child link --}}
                            <a 
                                {{-- href="{{ route('category.show', $child->slug) }}"  --}}
                                href="" 
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
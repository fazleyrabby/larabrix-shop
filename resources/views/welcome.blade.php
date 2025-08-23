@extends('frontend.app')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.theme.min.css">
    <style>
        /* .glide__arrow--left {
                                left: -5em !important;
                            }
                            .glide__arrow--right {
                                right: 5em !important;
                            } */
    </style>
@endpush
@section('content')
    @include('frontend.partials.nav')

    <div
        class="relative w-full h-[400px] md:h-[500px] overflow-hidden
            bg-gray-300
            bg-cover bg-center">

        <!-- Dark Overlay -->
        {{-- <div class="absolute inset-0 bg-black/40"></div> --}}

        <!-- Glide slider content -->
        <div class="relative w-full h-full">
            <div class="glide h-full">

                <div class="glide__track h-full" data-glide-el="track">
                    <ul class="glide__slides h-full">

                        <!-- Slide 1 -->
                        <li class="glide__slide flex items-center justify-between h-full px-4 md:px-16 gap-6">
                            <!-- Left: Title + Text + Button -->
                            <div
                                class="flex flex-col justify-center space-y-6 w-full md:w-2/5 p-6 rounded text-left h-full">
                                <h2 class="text-4xl font-bold text-gray-800">Slide Title</h2>
                                <p class="text-gray-700 text-lg">Promo text for the slide. Make it longer to utilize more
                                    space.</p>
                                <button class="px-8 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    Learn More
                                </button>
                            </div>

                            <!-- Right: Image -->
                            <div class="flex items-center justify-center w-full md:w-1/2 h-full">
                                <img src="https://images.unsplash.com/photo-1560769629-975ec94e6a86?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                    alt="Slide Image" class="object-cover rounded shadow max-w-full h-auto">
                            </div>
                        </li>

                        <!-- Slide 2 -->
                        <li class="glide__slide flex items-center justify-between h-full px-4 md:px-16 gap-6">
                            <!-- Left: Title + Text + Button -->
                            <div
                                class="flex flex-col justify-center space-y-6 w-full md:w-2/5 p-6 rounded text-left h-full">
                                <h2 class="text-4xl font-bold text-gray-800">Slide Title</h2>
                                <p class="text-gray-700 text-lg">Promo text for the slide. Make it longer to utilize more
                                    space.</p>
                                <button class="px-8 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    Learn More
                                </button>
                            </div>

                            <!-- Right: Image -->
                            <div class="flex items-center justify-center w-full md:w-1/2 h-full">
                                <img src="https://images.unsplash.com/photo-1585147877975-6acd0a929a46?q=80&w=3174&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                    alt="Slide Image" class="object-cover rounded shadow max-w-full h-auto">
                            </div>
                        </li>

                    </ul>
                </div>

                <!-- Arrows -->
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">Prev</button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">Next</button>
                </div>

            </div>
        </div>
    </div>


    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Shop by Category</h2>

        <div class="grid grid-cols-3 sm:grid-cols-6 gap-4 justify-items-center">
            @foreach ($categories as $id => $title)
                 <div class="flex flex-col items-center space-y-2 cursor-pointer">
                    <div
                        class="w-24 h-24 sm:w-28 sm:h-28 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden shadow hover:shadow-lg transition">
                        <img src="https://placehold.co/150x150/FF7F50/ffffff?text={{ $title }}" alt="{{ $title }}"
                            class="w-full h-full object-cover" />
                    </div>
                    <span class="text-sm font-medium text-center">{{ $title }}</span>
                </div>   
            @endforeach
        </div>
    </div>

    <div class="hero bg-base-200 page-container">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold">Hello there</h1>
                <p class="py-6">
                    Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem
                    quasi. In deleniti eaque aut repudiandae et a id nisi.
                </p>
                <button class="btn btn-primary">Get Started</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>

    <script>
        new Glide('.glide', {
            type: 'carousel',
            autoplay: 5000,
            hoverpause: true,
            perView: 1,
        }).mount()
    </script>
@endpush

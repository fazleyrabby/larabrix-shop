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

                <div class="glide__track h-full container mx-auto" data-glide-el="track">
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
                        <img src="https://placehold.co/150x150/FF7F50/ffffff?text={{ $title }}"
                            alt="{{ $title }}" class="w-full h-full object-cover" />
                    </div>
                    <span class="text-sm font-medium text-center">{{ $title }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <section class="py-8">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Trending Products</h2>

            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <!-- Product Card -->
                @foreach ($products as $product)
                    <div class="card bg-base-100 shadow hover:shadow-lg transition">
                        <figure>
                            <img src="{{ $product->fullImage }}" alt="{{ $product->title }}"
                                id="product-image-{{ $product->id }}" data-src="{{ $product->fullImage }}"
                                id="product-image-{{ $product->id }}"
                                class="h-40 w-full object-cover transition duration-500 group-hover:scale-105"
                                loading="lazy" />
                        </figure>
                        <div class="card-body p-4">
                            <h3 class="card-title text-lg">{{ $product->title }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ \Illuminate\Support\Str::words($product->short_description, 10, '...') }}
                            </p>
                            <div class="card-actions mt-2 justify-between items-center">
                                <span class="font-bold text-teal-600">${{ $product->price }}</span>
                                <button class="btn btn-sm btn-primary">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>

    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Deals</h2>
                <button class="btn btn-neutral">Show All Deals</button>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <!-- Product Card -->
                @foreach ($deals as $product)
                    <div class="card bg-base-100 shadow hover:shadow-lg transition">
                        <figure>
                            <img src="{{ $product->fullImage }}" alt="{{ $product->title }}"
                                id="product-image-{{ $product->id }}"
                                class="h-40 w-full object-cover transition duration-500 group-hover:scale-105"
                                loading="lazy" />
                        </figure>
                        <div class="card-body p-4">
                            <h3 class="card-title text-lg">{{ $product->title }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ \Illuminate\Support\Str::words($product->short_description, 10, '...') }}
                            </p>
                            <div class="card-actions mt-2 justify-between items-center">
                                <span class="font-bold text-teal-600">${{ $product->price }}</span>
                                <button class="btn btn-sm btn-primary">Add to Cart</button>
                            </div>

                            <!-- Countdown -->
                            <div class="mt-4" {{-- data-deadline="{{ $product->offer_end_date }}" --}}
                                data-deadline="{{ now()->addDays(30)->toIso8601String() }}"
                                id="countdown-{{ $product->id }}">
                                <div class="grid grid-cols-4 w-full text-center gap-3">
                                    <div class="flex flex-col items-center shadow-sm py-2">
                                        <span class="countdown font-mono text-xl">
                                            <span id="days-{{ $product->id }}" style="--value:0;">0</span>
                                        </span>
                                        days
                                    </div>
                                    <div class="flex flex-col items-center shadow-sm py-2">
                                        <span class="countdown font-mono text-xl">
                                            <span id="hours-{{ $product->id }}" style="--value:0;">0</span>
                                        </span>
                                        hours
                                    </div>
                                    <div class="flex flex-col items-center shadow-sm py-2">
                                        <span class="countdown font-mono text-xl">
                                            <span id="minutes-{{ $product->id }}" style="--value:0;">0</span>
                                        </span>
                                        min
                                    </div>
                                    <div class="flex flex-col items-center shadow-sm py-2">
                                        <span class="countdown font-mono text-xl">
                                            <span id="seconds-{{ $product->id }}" style="--value:0;">0</span>
                                        </span>
                                        sec
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>

    <section class="py-8">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">New Arriaval</h2>
            <div class="new-arrival">
                <!-- Track -->
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach ($products as $product)
                            <li class="glide__slide">
                                <div class="card bg-base-100 shadow hover:shadow-lg transition">
                                    <figure>
                                        <img src="{{ $product->fullImage }}" alt="{{ $product->title }}"
                                            id="product-image-{{ $product->id }}"
                                            class="h-40 w-full object-cover transition duration-500 group-hover:scale-105"
                                            loading="lazy" />
                                    </figure>
                                    <div class="card-body p-4">
                                        <h3 class="card-title text-lg">{{ $product->title }}</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ \Illuminate\Support\Str::words($product->short_description, 10, '...') }}
                                        </p>
                                        <div class="card-actions mt-2 justify-between items-center">
                                            <span class="font-bold text-teal-600">${{ $product->price }}</span>
                                            <button class="btn btn-sm btn-primary">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Arrows -->
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">‹</button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">›</button>
                </div>
            </div>
        </div>
    </section>

    <section class="py-8">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Recent Blogs</h2>
            <div class="mx-auto grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($blogs as $blog)
                <article
                    class="rounded-lg border border-gray-100 bg-white p-4 shadow-xs transition hover:shadow-lg sm:p-6">
                    <span class="inline-block rounded-sm bg-blue-600 p-2 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                    </span>

                    <a href="{{ route('frontend.blog.show', $blog->slug) }}">
                        <h3 class="mt-0.5 text-lg font-medium text-gray-900">
                            {{ $blog->title }}
                        </h3>
                    </a>

                    <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-500">
                        {{ \Illuminate\Support\Str::words(strip_tags($blog->body), 20, '...') }}
                    </p>

                    <a href="{{ route('frontend.blog.show', $blog->slug) }}"
                        class="group mt-4 inline-flex items-center gap-1 text-sm font-medium text-blue-600">
                        Find out more
                        <span aria-hidden="true" class="block transition-all group-hover:ms-0.5 rtl:rotate-180">
                            &rarr;
                        </span>
                    </a>
                </article>
            @endforeach
        </div>
        </div>
        
    </section>

    {{-- <div class="hero bg-base-200 page-container">
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
    </div> --}}
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

        new Glide('.new-arrival', {
            type: 'carousel',
            perView: 4,
            gap: 20,
            autoplay: 5000,
            hoverpause: true,
            breakpoints: {
                1024: {
                    perView: 3
                },
                768: {
                    perView: 2
                },
                480: {
                    perView: 1
                },
            }
        }).mount();
    </script>

    <script>
        function startCountdown(container) {
            const deadline = new Date(container.dataset.deadline).getTime();
            const productId = container.id.replace("countdown-", "");

            function update() {
                const now = new Date().getTime();
                const diff = deadline - now;

                if (diff <= 0) {
                    ["days", "hours", "minutes", "seconds"].forEach(unit => {
                        document.getElementById(`${unit}-${productId}`)
                            .style.setProperty("--value", 0);
                    });
                    return;
                }

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                document.getElementById(`days-${productId}`).style.setProperty("--value", days);
                document.getElementById(`hours-${productId}`).style.setProperty("--value", hours);
                document.getElementById(`minutes-${productId}`).style.setProperty("--value", minutes);
                document.getElementById(`seconds-${productId}`).style.setProperty("--value", seconds);
            }

            update();
            setInterval(update, 1000);
        }

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("[id^='countdown-']").forEach(startCountdown);
        });
    </script>
@endpush

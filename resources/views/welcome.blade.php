@extends('frontend.app')

@section('content')
    @php $categories = \App\Models\Category::whereNull('parent_id')->with('childrenRecursive')->get() @endphp
    <nav class="bg-gray-800 text-white">
        <div class="container mx-auto">
            <div class="flex items-center space-x-4">
                <ul class="flex space-x-4">
                    @include('frontend.partials.category-item', ['categories' => $categories])
                </ul>
            </div>
        </div>
    </nav>
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

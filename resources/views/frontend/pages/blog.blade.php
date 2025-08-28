@extends('frontend.app')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">

    <style>
        .prose {
            @apply max-w-none leading-relaxed;
        }

        /* Headings */
        .prose h1 {
            @apply text-4xl font-bold my-4;
        }

        .prose h2 {
            @apply text-3xl font-semibold my-3;
        }

        .prose h3 {
            @apply text-2xl font-semibold my-3;
        }

        .prose h4 {
            @apply text-xl font-semibold my-2;
        }

        .prose h5 {
            @apply text-lg font-medium my-2;
        }

        .prose h6 {
            @apply text-base font-medium my-2 text-gray-700;
        }

        .prose table {
            @apply w-full border border-gray-300 border-collapse my-4;
        }

        .prose th {
            @apply border border-gray-300 bg-gray-100 px-3 py-2 text-left font-semibold;
        }

        .prose td {
            @apply border border-gray-300 px-3 py-2;
        }

        .prose pre {
            @apply bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto my-4;
        }

        .prose iframe {
            @apply w-full h-96 rounded-lg my-4;
        }

        .prose p,
        .prose h1,
        .prose h2,
        .prose h3,
        .prose ul,
        .prose ol,
        .prose table,
        .prose pre,
        .prose blockquote,
        .prose img,
        .prose iframe {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        /* Table styling */
        .prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5em 0;
            font-size: 0.95rem;
        }

        .prose table th,
        .prose table td {
            border: 1px solid #ddd;
            padding: 0.75em;
            text-align: left;
        }

        .prose table th {
            background-color: #f9fafb;
            font-weight: 600;
        }

        .prose table tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* YouTube iframe responsive */
        .prose iframe {
            width: 100%;
            height: 400px;
            border-radius: 8px;
        }

        /* Pre/code block styling */
        .prose pre {
            background: #1e293b;
            color: #f8fafc;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>
@endpush


@section('content')
    <section class="min-h-screen bg-white py-12">
        <div class="max-w-3xl mx-auto px-4">

            <!-- Blog Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                {{ $blog->title ?? 'Blog Post Title' }}
            </h1>

            <!-- Blog Metadata -->
            <div class="text-sm text-gray-500 mb-6">
                <span>By {{ $blog->author ?? 'Author Name' }}</span>
                <span class="mx-2">·</span>
                <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('F j, Y') ?? 'Date' }}</span>
            </div>

            <!-- Featured Image -->
            @if (!empty($blog->image))
                <img src="{{ $blog->image }}" alt="Featured Image"
                    class="w-full rounded-lg mb-8 object-cover max-h-[400px]" />
            @endif

            <!-- Blog Content -->
            <div class="prose prose-lg max-w-none leading-relaxed">
                {!! $blog->body !!}
                </article>

                <!-- Optional Tags or Categories -->
                @if (!empty($blog->tags))
                    <div class="mt-8 flex flex-wrap gap-2">
                        @foreach ($blog->tags as $tag)
                            <span class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                #{{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif

            </div>
    </section>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Hasil Pencarian untuk: "{{ $searchQuery }}"</h2>

        @if($posts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden dark:bg-gray-800">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">
                                <a href="/posts/{{ $post->slug }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $post->title }}</a>
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Published on: {{ $post->published_at->format('M d, Y') }}</p>
                            <p class="mt-2 text-gray-700 dark:text-gray-300">{{ Str::limit($post->excerpt, 100) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
            {{ $posts->links('vendor.pagination.custom') }}
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400">Tidak ada artikel yang ditemukan.</p>
        @endif
    </div>
@endsection

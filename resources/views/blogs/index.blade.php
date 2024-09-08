@extends('layouts.app')

@section('content')
        <!-- Section untuk Artikel Populer atau Terbaru -->
        @if($featuredPost)
        <section class="mb-8 text-justify">
            <div class="relative bg-white rounded-lg shadow-lg overflow-hidden dark:bg-gray-800">
                <img src="{{ $featuredPost->gambar }}" alt="{{ $featuredPost->title }}" class="w-full h-64 md:h-[20rem] object-cover" loading="lazy">
                <div class="absolute top-2 right-2 bg-green-500 text-white rounded-md p-2 text-sm font-medium shadow-md">
                    Terbaru
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-3">
                        <a href="/blogs/{{ $featuredPost->slug }}" class="text-pink-600 hover:underline dark:text-pink-400">{{ $featuredPost->title }}</a>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Published on: {{ $featuredPost->published_at->format('M d, Y') }}</p>
                    <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                        {{ \Illuminate\Support\Str::limit($featuredPost->excerpt, 180, '...') }}
                    </p>
                </div>
            </div>
        </section>
        @endif

        <!-- Menampilkan Form Select untuk Kategori -->
        <div class="mb-6">
            <form action="{{ route('blogs.index') }}" method="GET">
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Kategori:</label>
                <select name="category" id="category" onchange="this.form.submit()" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm dark:bg-gray-700 dark:text-gray-300">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="lg:flex lg:space-x-8 text-justify">
            <!-- Blog Posts Section -->
            <div class="w-full">
                <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-6">
                    @foreach($posts as $post)
                        <div class="relative bg-white rounded-lg shadow-lg overflow-hidden dark:bg-gray-800">
                            <img src="{{ $post->gambar }}" alt="{{ $post->title }}" class="w-full h-48 object-cover" loading="lazy">
                            
                            <div class="p-4">
                                <h3 class="text-xl font-semibold mb-2">
                                    <a href="/blogs/{{ $post->slug }}" class="text-pink-600 hover:underline dark:text-pink-400">{{ $post->title }}</a>
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Published on: {{ $post->published_at->format('M d, Y') }}</p>
                                <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                                    {{ Str::limit($post->excerpt, 120, '...') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $posts->links('vendor.pagination.custom') }}
                </div>
            </div>

            <!-- Tags Section (Mobile Only) -->
            <div class="lg:hidden mt-8">
                <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg mb-6">
                    <h3 class="text-lg font-semibold mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="/tags/{{ $tag->slug }}" class="text-sm bg-pink-100 text-pink-800 px-2 py-1 rounded-md">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endsection

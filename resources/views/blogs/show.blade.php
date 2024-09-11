@extends('layouts.app')

@section('title', $post->title)

@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->body), 150))

@section('meta_keywords', implode(', ', $post->tags->pluck('name')->toArray()))

@section('og_image', $post->gambar)

@section('css')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Hilangkan padding bawaan dari Quill */
    .ql-editor {
        padding: 0 !important; /* Menghilangkan padding */
        line-height: 1.6; /* Sesuaikan line-height agar lebih mudah dibaca */
    }

    /* Sesuaikan warna font untuk kenyamanan membaca */
    .ql-editor p, 
    .ql-editor li {
        color: #4a4a4a; /* Gunakan warna abu-abu lembut agar tidak terlalu tajam di mata */
        font-size: 1rem; /* Sesuaikan ukuran font agar lebih mudah dibaca */
    }

    /* Sesuaikan gaya untuk heading */
    .ql-editor h1 {
        font-size: 1.5rem;
        color: #333333; /* Warna heading yang sedikit lebih gelap untuk kontras */
    }

    .ql-editor h2 {
        font-size: 1.3rem;
        color: #444444; /* Heading 2 sedikit lebih kecil dan terang dari h1 */
    }

    .ql-editor h3 {
        font-size: 1.1rem;
        color: #555555; /* Heading 3 sedikit lebih kecil dan lebih lembut */
    }

    /* Sesuaikan warna link */
    .ql-editor a {
        color: #1d72b8; /* Warna biru yang lebih lembut untuk link */
        text-decoration: underline;
    }

    /* Gaya untuk list */
    .ql-editor ul, 
    .ql-editor ol {
        margin-left: 0rem; /* Menambahkan indentasi untuk list agar lebih rapi */
        padding-left: 0rem;
    }

    /* Gaya untuk blockquote */
    .ql-editor blockquote {
        color: #666666;
        font-style: italic;
        border-left: 4px solid #dddddd;
        padding-left: 1rem;
        margin-left: 0;
        margin-right: 0;
    }
    /* Card Styling for Carousel */
    .carousel-card {
        flex-shrink: 0; /* Prevent cards from shrinking */
        width: 340px; /* Set consistent width for each card */
        height: auto; /* Auto height based on content */
        min-height: 200px; /* Set a minimum height to avoid stretching */
        max-width: 100%; /* Ensure it doesn’t overflow container */
        box-sizing: border-box; /* Ensure padding is included in the width */
    }
</style>

@endsection
@section('content')
    <article>
        <img src="{{ $post->gambar }}" alt="{{ $post->title }}" class="w-full rounded-md h-52 md:h-64 object-fill" loading="lazy">
        <p class="text-gray-600 mb-2 pl-2 text-xs pt-[0.3em]">{{ $post->published_at ? $post->published_at->format('M d, Y') : '-' }} by {{ $post->author->name }}</p>
        <h2 class="text-2xl font-bold my-4 text-center">{{ $post->title }}</h2>
        <div class="text-gray-700 dark:text-gray-300 leading-relaxed ql-editor">
            {!! $post->body !!}
        </div>
    </article>

    <div class="mb-8">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-lg font-semibold mb-4">Tags</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($post->tags as $tag)
                    <a href="/tags/{{ $tag->slug }}" class="text-sm bg-pink-100 text-pink-800 px-2 py-1 rounded-md">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section Bagikan Artikel -->
    <section class="my-12">
        <h4 class="text-lg font-semibold mb-4">Bagikan Artikel Ini</h4>
        <div class="flex space-x-4">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank" class="bg-blue-600 text-white p-3 px-[19px] rounded-full">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}" target="_blank" class="bg-blue-400 text-white p-3 px-4 rounded-full">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://wa.me/?text={{ urlencode(Request::url()) }}" target="_blank" class="bg-green-500 text-white p-3 px-4 rounded-full">
                <i class="fab fa-whatsapp fa-lg"></i>
            </a>
            <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(Request::url()) }}" target="_blank" class="bg-blue-700 text-white p-3 px-4 rounded-full">
                <i class="fab fa-linkedin-in fa-lg"></i>
            </a>
        </div>
    </section>

     <!-- Section Artikel Terkait -->
     @if($relatedPosts->count() > 0)
        <section class="mb-12">
            <h4 class="text-lg font-semibold mb-4">Artikel Terkait</h4>
            <div class="relative">
                <!-- Tombol Prev -->
                <button id="prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white p-2 rounded-full z-[1]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Carousel Container -->
                <div id="carousel" class="flex overflow-x-hidden scroll-smooth space-x-4">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="carousel-card bg-white p-3 rounded-lg text-justify shadow-md border">
                            <h3 class="font-bold mb-2">
                                <a href="{{ url('blogs', $relatedPost->slug) }}" class="text-pink-600 hover:underline dark:text-pink-400">{{ $relatedPost->title }}</a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-2">
                                {{ $relatedPost->published_at ? $relatedPost->published_at->format('M d, Y') : '-' }}
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">{{ Str::limit($relatedPost->excerpt, 100) }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Tombol Next -->
                <button id="next" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white p-2 rounded-full z-[1]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </section>
    @endif

    <!-- Section Komentar -->
    <section class="mt-12">
        <h4 class="text-xl font-bold mb-4">Komentar Pembaca</h4>
        
        @if($comments->count() === 0)
            <span class="text-sm">Belum ada komentar disini</span>
        @endif
        <!-- Daftar Komentar -->
        <div id="comments-section">
            @foreach($comments as $comment)
                <div class="bg-white p-4 rounded-lg shadow-md border mb-4">
                    <!-- Komentar Utama -->
                    <div class="flex items-center mb-2">
                        <img src="https://secure.gravatar.com/avatar/0eac92b304e168a1119a37a3908f6442?s=50&d=mm&r=g" alt="User Avatar" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <h3 class="font-semibold">
                                @if($comment->user)
                                    {{ $comment->user->name }}
                                @else
                                    {{ $comment->guest_name }}
                                @endif
                            </h3>
                            <p class="text-xs text-gray-500">Posted on {{ $comment->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm">{{ $comment->body }}</p>
                    
                    <!-- Tombol Balas dan Jumlah Balasan -->
                    <div class="flex items-center mt-4 justify-between">
                        <button class="text-gray-500 hover:text-gray-600" onclick="toggleReplyForm({{ $comment->id }})">Balas</button>
                        @if($comment->replies->count() > 0)
                            <span class="text-gray-500 hover:text-purple-400 cursor-pointer underline" onclick="toggleReplies({{ $comment->id }})" id="toggle-replies-{{ $comment->id }}">
                                {{ $comment->replies->count() }} balasan
                            </span>
                        @endif
                    </div>

                    <!-- Form untuk membalas komentar -->
                    <div id="reply-form-{{ $comment->id }}" class="hidden mt-4">
                        <form action="{{ route('comments.reply', $comment->id) }}" method="POST">
                            @csrf
                            @guest
                                <div class="mb-4">
                                    <input type="text" name="guest_name" class="w-full p-2 border border-gray-300 rounded-md mb-2" placeholder="Nama" required>
                                    <input type="email" name="guest_email" class="w-full p-2 border border-gray-300 rounded-md mb-2" placeholder="Email">
                                </div>
                            @endguest
                            <textarea name="body" rows="2" class="w-full p-2 border border-gray-300 rounded-md mb-2" placeholder="Tulis balasan Anda..."></textarea>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Kirim Balasan</button>
                        </form>
                    </div>

                    <!-- Menampilkan Balasan Komentar -->
                    @if($comment->replies->count() > 0)
                        <div id="replies-{{ $comment->id }}" class="hidden mt-4 ml-6">
                            @foreach($comment->replies as $reply)
                                <div class="bg-white p-4 rounded-lg shadow-md border mb-4">
                                    <div class="flex items-center mb-2">
                                        @if(optional($reply->user)->role === 'admin')
                                            <img src="{{ $reply->user->avatar }}" alt="User Avatar" class="w-10 h-10 rounded-full mr-3">
                                        @else
                                            <img src="https://secure.gravatar.com/avatar/0eac92b304e168a1119a37a3908f6442?s=50&d=mm&r=g" alt="User Avatar" class="w-10 h-10 rounded-full mr-3">
                                        @endif
                                        
                                        <div>
                                            <h3 class="font-semibold">
                                                @if($reply->user)
                                                    {{ $reply->user->name }}
                                                @else
                                                    {{ $reply->guest_name }}
                                                @endif
                                            </h3>
                                            <p class="text-xs text-gray-500">Posted on {{ $reply->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-gray-700 text-sm">{{ $reply->body }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @if($comments->count() > 0)
        <!-- Pagination -->
        <div class="mt-8">
            {{ $comments->links('vendor.pagination.custom') }}
        </div>
        @endif
        <!-- Form Komentar Baru -->
        <div class="my-8">
            <h4 class="text-lg font-semibold mb-2">Tinggalkan Komentar</h4>
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex flex-col">
                @csrf
                @guest
                    <div class="mb-4">
                        <input type="text" name="guest_name" class="w-full p-2 border border-gray-300 rounded-md mb-2" placeholder="Nama" required>
                        <input type="email" name="guest_email" class="w-full p-2 border border-gray-300 rounded-md mb-2" placeholder="Email">
                    </div>
                @endguest
                <div class="mb-4">
                    <textarea name="body" rows="4" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Tulis komentar Anda di sini..."></textarea>
                </div>

                <!-- Tambahkan div pembungkus dengan justify-end untuk memindahkan tombol ke kanan -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Kirim Komentar</button>
                </div>
            </form>
        </div>

    </section>

    <!-- Scroll to Top Button -->
    <button id="scrollToTopBtn" class="fixed bottom-8 right-4 bg-blue-500 text-white p-2 rounded-full shadow-lg hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>
@endsection
@push('script')
<script>
    // Scroll to top button
    const scrollToTopBtn = document.getElementById('scrollToTopBtn');
    const rootElement = document.documentElement;

    function handleScroll() {
        // Show or hide button based on scroll position
        if (rootElement.scrollTop > 200) {
            scrollToTopBtn.classList.remove('hidden');
        } else {
            scrollToTopBtn.classList.add('hidden');
        }
    }

    function scrollToTop() {
        // Scroll back to the top
        rootElement.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }

    scrollToTopBtn.addEventListener('click', scrollToTop);
    document.addEventListener('scroll', handleScroll);

    // Fungsi untuk menampilkan/menghilangkan form balasan
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
        } else {
            form.classList.add('hidden');
        }
    }

    // Fungsi untuk menampilkan/menghilangkan balasan
    function toggleReplies(commentId) {
        const replies = document.getElementById(`replies-${commentId}`);
        const toggleButton = document.getElementById(`toggle-replies-${commentId}`);
        
        if (replies.classList.contains('hidden')) {
            replies.classList.remove('hidden');
            toggleButton.innerText = 'Sembunyikan balasan';
        } else {
            replies.classList.add('hidden');
            toggleButton.innerText = `${replies.children.length} balasan`;
        }
    }

    const carousel = document.getElementById('carousel');
    const nextButton = document.getElementById('next');
    const prevButton = document.getElementById('prev');

    if (carousel) {
        // Scroll ke kanan
        nextButton.addEventListener('click', () => {
            carousel.scrollBy({
                left: 300, // Sesuaikan dengan lebar item
                behavior: 'smooth'
            });
        });

        // Scroll ke kiri
        prevButton.addEventListener('click', () => {
            carousel.scrollBy({
                left: -300, // Sesuaikan dengan lebar item
                behavior: 'smooth'
            });
        });
    }

</script>
@endpush

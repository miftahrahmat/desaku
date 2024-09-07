@extends('layouts.admin')

@section('css')
<style>
    #editor-container {
        height: 400px;
    }
    .ql-editor {
        white-space: pre-wrap !important;
    }
    .ql-align-justify {
        margin-bottom: 0.5em !important;
    }
</style>
@endsection

@section('content')
    <div class="p-4">
        <h2 class="text-2xl font-bold mb-4">Edit Article</h2>
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" 
                        value="{{ old('title', $post->title) }}"
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        required>
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" 
                        value="{{ old('slug', $post->slug) }}"
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        required>
                </div>

                <!-- Excerpt -->
                <div class="md:col-span-2 mb-4">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3" 
                        class="mt-1 block w-full rounded-md p-3 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        required>{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label for="categories" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="categories[]" id="categories" 
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        multiple required>
                        @foreach($categories as $cate)
                            <option value="{{ $cate->id }}" {{ in_array($cate->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $cate->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tag -->
                <div class="mb-4">
                    <label for="tags" class="block text-sm font-medium text-gray-700">Tag</label>
                    <select name="tags[]" id="tags" 
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        multiple required>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Author -->
                <div class="mb-4">
                    <label for="author_id" class="block text-sm font-medium text-gray-700">Author</label>
                    <select name="author_id" id="author_id" 
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        required>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ $author->id == old('author_id', $post->author_id) ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Published At -->
                <div class="mb-4">
                    <label for="published_at" class="block text-sm font-medium text-gray-700">Published At</label>
                    <input type="datetime-local" name="published_at" id="published_at" 
                        value="{{ old('published_at', $post->published_at->format('Y-m-d\TH:i')) }}"
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        required>
                </div>

                <!-- Featured Image -->
                <div class="md:col-span-2 mb-4 relative">
                    <label for="image" class="relative text-sm font-medium text-gray-700">Featured Image</label>
                    <input id="image" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        type="text" name="image" placeholder="Choose image..." 
                        value="{{ old('image', $post->gambar) }}" required>
                    <button id="lfm-btn" type="button" class="absolute top-[31px] right-1 text-white bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded-md focus:outline-none">Pilih</button>
                </div>

                <div class="md:col-span-2 mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                    <div id="editor-container" class="bg-white border border-gray-300 rounded-md"></div>
                    <textarea name="body" id="body" style="display: none;">{{ old('body', $post->body) }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 mt-6 flex justify-between">
                    <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Article
                    </button>

                    <a href="{{ route('admin.posts.index') }}" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <!-- Quill.js -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['link', 'image'],
                    [{ 'align': [] }],
                    ['clean']
                ]
            },
        });

        // Set the initial content from the database
        var contentFromDatabase = `{!! addslashes($post->body) !!}`;
        quill.clipboard.dangerouslyPasteHTML(contentFromDatabase);

        // Synchronize Quill content with hidden textarea on change
        quill.on('text-change', function(delta, oldDelta, source) {
            var content = quill.root.innerHTML.trim();
            document.querySelector('#body').value = content;
        });

        // Synchronize Quill content with hidden textarea when form is submitted
        document.querySelector('form').addEventListener('submit', function(e) {
            var content = quill.root.innerHTML.trim();
            if (content === '' || content === '<p><br></p>') {
                e.preventDefault(); // Prevent form submission
                alert('Body tidak boleh kosong!');
                return;
            }
            document.querySelector('#body').value = content;
        });
    </script>

    <!-- Laravel File Manager -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $(document).ready(function () {
            var route_prefix = "/laravel-filemanager"; // Sesuaikan dengan route LFM

            // Fungsi untuk membuka file manager
            $('#lfm-btn').filemanager('image', {prefix: route_prefix});

            // Menghubungkan file manager dengan input gambar
            $('#lfm-btn').on('click', function (event) {
                event.preventDefault();

                // Fungsi untuk membuka file manager dan mengambil URL
                window.SetUrl = function (items) {
                    // Mengambil URL gambar dari objek JSON dan mengisi input form
                    var imageUrl = items[0].url; // URL gambar dari objek
                    $('#image').val(imageUrl); // Mengisi input dengan URL gambar
                };
            });
        });
    </script>
@endpush

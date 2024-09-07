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
        <h2 class="text-2xl font-bold mb-4">Create New Article</h2>
        <form id="form" action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" 
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        required>
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" 
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        required>
                </div>

                <!-- Excerpt -->
                <div class="md:col-span-2 mb-4">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3" class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" maxlength="280" required></textarea>
                    <div id="excerpt-count" class="text-sm text-gray-500">0/250 characters used</div>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label for="categories" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="categories[]" id="categories" 
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        multiple="multiple">
                        <!-- Options akan diisi oleh Select2 melalui AJAX -->
                    </select>
                </div>

                <!-- Tag -->
                <div class="mb-4">
                    <label for="tags" class="block text-sm font-medium text-gray-700">Tag</label>
                    <select name="tags[]" id="tags" 
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        multiple="multiple">
                        <!-- Options akan diisi oleh Select2 melalui AJAX -->
                    </select>
                </div>

                <!-- Author -->
                <div class="mb-4">
                    <label for="author_id" class="block text-sm font-medium text-gray-700">Author</label>
                    <select name="author_id" id="author_id" 
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        required>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Published At -->
                <div class="mb-4">
                    <label for="published_at" class="block text-sm font-medium text-gray-700">Published At</label>
                    <input type="datetime-local" name="published_at" id="published_at" 
                        class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        required>
                </div>

                <!-- Featured Image -->
                <div class="md:col-span-2 mb-4 relative">
                    <label for="image" class="relative text-sm font-medium text-gray-700">Featured Image</label>
                    <input id="image" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        type="text" name="image" placeholder="Choose image..." required>
                    <button id="lfm-btn" type="button" class="absolute top-[31px] right-1 text-white bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded-md focus:outline-none">Pilih</button>
                </div>

                <!-- Body (Quill Editor) -->
                <div class="md:col-span-2 mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                    <div id="editor-container" style="height: 300px;" class="border border-gray-300 rounded-md"></div>
                    
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 mt-6 flex justify-between">
                    <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Publish Article
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        
        var config = { childList: true, subtree: true };
        //observer.observe(document.querySelector('#editor-container'), config);

        // Initialize Quill editor
        var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [3, false] }],
                ['bold', 'italic', 'underline'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                ['link', 'image'],
                [{ 'align': [] }],
                ['clean']
            ]
        },
        placeholder: 'Masukkan artikel disini...'
    });

    document.querySelector('#form').addEventListener('submit', function(e) {
        var description = quill.root.innerHTML;

        // Pastikan input hidden untuk body ditambahkan sebelum form dikirim
        var bodyInput = document.createElement('input');
        bodyInput.type = 'hidden';
        bodyInput.name = 'body';
        bodyInput.value = description;
        this.appendChild(bodyInput);
    });

    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Select2 untuk Kategori dan Tag -->
    <script>
        $(document).ready(function() {
            function formatResult(item) {
                if (item.loading) return item.text;
                return item.text;
            }

            function formatSelection(item) {
                return item.text;
            }

            // Initialize Select2 for Categories
            $('#categories').select2({
                tags: true,
                placeholder: 'Select or add new categories',
                tokenSeparators: [','], // Allow paste with comma-separated values
                ajax: {
                    url: '{{ route("api.categories.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(category) {
                                return { id: category.slug, text: category.name };
                            })
                        };
                    },
                    cache: true
                },
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true // Add additional parameters
                    };
                },
                templateResult: formatResult,
                templateSelection: formatSelection
            });

            // Initialize Select2 for Tags
            $('#tags').select2({
                tags: true,
                placeholder: 'Select or add new tags',
                tokenSeparators: [','], // Allow paste with comma-separated values
                ajax: {
                    url: '{{ route("api.tags.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(tag) {
                                return { id: tag.slug, text: tag.name };
                            })
                        };
                    },
                    cache: true
                },
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true // Add additional parameters
                    };
                },
                templateResult: formatResult,
                templateSelection: formatSelection
            });
        });

    </script>

    <!-- Laravel File Manager -->
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        // Slugify: Generate Slug from Title
        document.getElementById('title').addEventListener('input', function () {
            var title = this.value;
            var slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            document.getElementById('slug').value = slug;
        });
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

        document.getElementById('excerpt').addEventListener('input', function () {
            const charCount = this.value.length;
            document.getElementById('excerpt-count').textContent = `${charCount}/250 characters used`;

            if (charCount > 250) {
                document.getElementById('excerpt-count').classList.add('text-red-600');
            } else {
                document.getElementById('excerpt-count').classList.remove('text-red-600');
            }
        });
    </script>
@endpush
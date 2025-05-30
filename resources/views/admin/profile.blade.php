@extends('layouts.admin')

@section('css')
    <!-- CSS Tambahan untuk Styling -->
    <style>
        /* Tambahan styling untuk responsive behavior */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
@endsection

@section('content')
<div class="flex md:mt-12 justify-between flex-wrap">
    @if(session('success'))
    <div class="w-full p-4 mb-4 text-green-700 bg-green-100 border border-green-200 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="w-full p-4 mb-4 text-red-700 bg-red-100 border border-red-200 rounded-lg">
        {{ session('error') }}
    </div>
    @endif
    <!-- Section pertama: Card Profile -->
    <div class="w-full lg:w-1/4 p-6 mb-6 lg:mb-0 lg:mr-4">
        <div class="text-center">
            <img class="h-24 w-24 rounded-full mx-auto border-4 border-blue-500" src="{{ $user->avatar }}" alt="Avatar">
            <h2 class="text-xl font-semibold mt-4">{{ $user->name }}</h2>
        </div>
    </div>

    <!-- Section kedua: Form berdasarkan Tabs -->
    <div class="w-full">
        <!-- Tabs -->
        <ul class="flex justify-between mb-4 border-b border-gray-200">
            <li class="flex-1 text-center">
                <a class="block py-2 px-4 rounded-t text-gray-500 hover:text-blue-700 font-semibold cursor-pointer active-tab" data-tab="profile">Profile</a>
            </li>
            <li class="flex-1 text-center">
                <a class="block py-2 px-4 rounded-t text-gray-500 hover:text-blue-700 font-semibold cursor-pointer" data-tab="settings">Settings</a>
            </li>
            <li class="flex-1 text-center">
                <a class="block py-2 px-4 rounded-t text-gray-500 hover:text-blue-700 font-semibold cursor-pointer" data-tab="security">Security</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <!-- Profile Tab Content -->
            <div id="profile" class="tab-content active">
                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    <input type="hidden" name="profile_tab" value="1">
                    <div class="md:col-span-2 mb-4 relative">
                        <label for="avatar" class="relative text-sm font-medium text-gray-700">Avatar</label>
                        <input id="avatar" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 text-gray-700 border bg-slate-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                            type="text" name="avatar" placeholder="Choose avatar..." value="{{ old('avatar', $user->avatar) }}">
                        <button id="lfm-avatar" type="button" class="absolute top-[34px] right-1 text-white text-xs bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded-md focus:outline-none">Pilih</button>
                    </div>

                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-2 bg-slate-300 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('name', $user->name) }}">
                    </div>
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full bg-slate-300 px-4 py-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
                </form>
            </div>

            <!-- Settings Tab Content -->
            <div id="settings" class="tab-content">
                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    <input type="hidden" name="settings_tab" value="1">
                    <!-- Website Name -->
                    <div class="mb-4">
                        <label for="website_name" class="block text-sm font-medium text-gray-700">Website Name</label>
                        <input type="text" name="website_name" id="website_name" value="{{ old('website_name', get_setting('website_name')) }}" class="mt-1 block w-full px-4 py-2 bg-slate-300 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>  
                    <div class="md:col-span-2 mb-4 relative">
                        <label for="website_icon" class="relative text-sm font-medium text-gray-700">Website Icon</label>
                        <input id="website_icon" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 text-gray-700 border bg-slate-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                            type="text" name="website_icon" placeholder="Choose icon..." value="{{ old('website_icon', get_setting('website_icon')) }}">
                        <button id="lfm-icon" type="button" class="absolute top-[34px] right-1 text-white text-xs bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded-md focus:outline-none">Pilih</button>
                    </div>
                    <!-- Footer Text -->
                    <div class="mb-4">
                        <label for="footer_text" class="block text-sm font-medium text-gray-700">Footer Text</label>
                        <input name="footer_text" id="footer_text" value="{{ old('footer_text', get_setting('footer_text')) }}" class="mt-1 block w-full bg-slate-300 px-4 py-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
                </form>
            </div>

            <!-- Security Tab Content -->
            <div id="security" class="tab-content">
                <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        @method('PUT')
                    <input type="hidden" name="security_tab" value="1">
                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full bg-slate-300 px-4 py-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block bg-slate-300 w-full px-4 py-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- JavaScript untuk Tab Interaktif -->
    <!-- Laravel File Manager -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('[data-tab]');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const target = this.getAttribute('data-tab');

                    // Ubah tampilan tab aktif
                    tabs.forEach(t => t.classList.remove('text-blue-700', 'border-b-2', 'border-blue-700'));
                    this.classList.add('text-blue-700', 'border-b-2', 'border-blue-700');

                    // Sembunyikan semua konten tab
                    tabContents.forEach(tc => tc.classList.remove('active'));
                    tabContents.forEach(tc => tc.classList.add('hidden'));

                    // Tampilkan konten tab yang dipilih
                    document.getElementById(target).classList.add('active');
                    document.getElementById(target).classList.remove('hidden');
                });
            });

            // Pilih tab pertama sebagai default
            tabs[0].click();
        });

        $(document).ready(function () {
            var route_prefix = "/laravel-filemanager"; // Sesuaikan dengan route LFM

            // Fungsi untuk membuka file manager
            $('#lfm-avatar').filemanager('image', {prefix: route_prefix});
            
            // File manager untuk website icon
            $('#lfm-icon').filemanager('image', {prefix: route_prefix});

            // Menghubungkan file manager dengan input gambar
            $('#lfm-avatar').on('click', function (event) {
                event.preventDefault();

                // Fungsi untuk membuka file manager dan mengambil URL
                window.SetUrl = function (items) {
                    // Mengambil URL gambar dari objek JSON dan mengisi input form
                    var imageUrl = items[0].url; // URL gambar dari objek
                    $('#avatar').val(imageUrl); // Mengisi input dengan URL gambar
                };
            });

            $('#lfm-icon').on('click', function (event) {
                event.preventDefault();

                // Fungsi untuk membuka file manager dan mengambil URL
                window.SetUrl = function (items) {
                    // Mengambil URL gambar dari objek JSON dan mengisi input form
                    var imageUrl = items[0].url; // URL gambar dari objek
                    $('#website_icon').val(imageUrl); // Mengisi input dengan URL gambar
                };
            });
        });
    </script>
@endpush

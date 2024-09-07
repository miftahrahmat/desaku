<!-- Sidebar -->
<div class="sidebar hidden md:flex flex-col w-64 h-screen bg-gray-800 text-white fixed inset-y-0 left-0 transition-transform duration-200 ease-in-out z-30">
    <div class="flex items-center justify-center h-16 bg-gray-900">
        <a href="#" class="text-xl font-bold">{{ get_setting('website_name') }}</a>
    </div>
    <nav class="flex-grow px-4 py-6">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }} block px-4 py-2 mt-2 text-sm font-semibold text-white rounded-lg hover:bg-gray-600">Dashboard</a>
        <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.index', 'admin.posts.create', 'admin.posts.edit') ? 'bg-gray-700' : '' }} block px-4 py-2 mt-2 text-sm font-semibold text-white rounded-lg hover:bg-gray-600">Posts</a>
        <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'bg-gray-700' : '' }} block px-4 py-2 mt-2 text-sm font-semibold text-white rounded-lg hover:bg-gray-600">Profile</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="{{ request()->routeIs('logout') ? 'bg-gray-700' : '' }} px-4 py-2 mt-2 text-sm font-semibold text-white rounded-lg hover:bg-gray-600">Logout</button>
        </form>
    </nav>
</div>

<!-- Mobile menu button -->
<div class="md:hidden fixed top-0 right-0 z-40 p-4">
    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false" onclick="toggleMobileMenu()">
        <span class="sr-only">Open main menu</span>
        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

<!-- Mobile menu, show/hide based on menu state. -->
<div class="mobile-menu hidden fixed inset-0 bg-gray-800 bg-opacity-75 z-50 flex items-center justify-center" id="mobile-menu">
    <div class="bg-gray-800 text-white w-full h-full p-4">
        <div class="flex justify-end">
            <button type="button" class="rounded-full bg-gray-700 p-2" onclick="toggleMobileMenu()">
                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="mt-8 space-y-4">
            <a href="#" class="block px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded-lg hover:bg-gray-600">Home</a>
            <a href="#" class="block px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded-lg hover:bg-gray-600">Informasi Akun</a>
            <a href="#" class="block px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded-lg hover:bg-gray-600">Buat Template</a>
            <a href="#" class="block px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded-lg hover:bg-gray-600">Percakapan</a>
            <a href="#" class="block px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded-lg hover:bg-gray-600">Kelola BOT</a>
            <a href="#" class="block px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded-lg hover:bg-gray-600">Logout</a>
        </nav>
    </div>
</div>

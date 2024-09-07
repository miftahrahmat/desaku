<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', get_setting('website_name'))</title>
    @vite('resources/css/app.css')
    @yield('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex">
    @include('layouts.navigation')
    <div class="flex-grow md:ml-[17rem]">
        <main class="container mx-auto md:w-5/6 w-full">
            @yield('content')
        </main>
    </div>
    
    <script>
        function toggleMobileMenu() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>

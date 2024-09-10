<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', get_setting('website_name'))</title>
    <meta name="application-name" content="{{ get_setting('website_name') }}">
    <meta name="description" content="@yield('meta_description', 'Default meta description')">

    <meta name="keywords" content="@yield('meta_keywords', 'default, keywords')">

    <meta property="og:title" content="@yield('title', get_setting('website_name'))">
    <meta property="og:description" content="@yield('meta_description', 'Default meta description')">
    <meta property="og:image" content="@yield('og_image', get_setting('website_icon'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', get_setting('website_name'))">
    <meta name="twitter:description" content="@yield('meta_description', 'Default meta description')">
    <meta name="twitter:image" content="@yield('og_image', get_setting('website_icon'))">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ get_setting('website_icon') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ get_setting('website_icon') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ get_setting('website_icon') }}">

    <link rel="canonical" href="{{ url()->current() }}">
    
    @vite('resources/css/app.css')
    @yield('css')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* Global Font Styling */
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        h2, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            color: #F4978E;
        }

        button, input[type="text"] {
            font-family: 'Poppins', sans-serif;
            border-radius: 0.375rem;
            border: none;
            outline: none;
            transition: all 0.3s ease;
        }

        button {
            background-color: #F4978E;
            color: white;
            padding: 0.2rem 0.6rem;
        }

        button:hover {
            background-color: #c3aed6;
        }

        input[type="text"] {
            background-color: #FFF5F3;
            border: 1px solid #FAD4C0;
            color: #333;
        }

        input[type="text"]::placeholder {
            color: #C3AED6;
        }

        input[type="text"]:focus {
            border-color: #F4978E;
            box-shadow: 0 0 5px rgba(244, 151, 142, 0.5);
        }

        header {
            background-color: #FAD4C0;
        }

        header a {
            color: #f472b58a;
            font-family: 'Playfair Display', serif;
            text-decoration: none;
        }

        header a:hover {
            color: #FFF5F3;
        }

        /* Footer Styling */
        footer {
            background-color: #F4978E;
            color: white;
        }

        footer p {
            font-family: 'Playfair Display', serif;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" defer>
    
</head>
<body class="flex flex-col min-h-screen max-w-xl mx-auto relative bg-white">
    
    <header class="p-3 shadow-md rounded-b-sm w-full md:w-[576px] fixed top-0 z-10">
        <div class="flex items-center justify-between">
           
            <h1 class="text-xl font-bold md:text-2xl">
                <a href="/">{{ get_setting('website_name') ?? 'Your Name' }}</a>
            </h1>

            <div class="hidden md:flex flex-grow justify-center md:ml-8">
                <form action="{{ route('posts.search') }}" method="GET" class="w-full max-w-lg">
                    <input type="text" name="query" placeholder="Cari artikel disini..." class="p-2 w-full rounded-md" value="{{ request('query') }}">
                </form>
            </div>

            <div class="flex items-center md:hidden space-x-2">
                <form action="{{ route('posts.search') }}" method="GET">
                    <input type="text" name="query" placeholder="Search..." class="p-2 w-[12rem] rounded-md" value="{{ request('query') }}">
                </form>
                <button id="menu-toggle" class="p-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

        </div>

        <div id="mobile-menu" class="hidden flex-col items-center md:hidden p-4">
            <a href="/" class="block py-2">About</a>
            <a href="/portfolio" class="block py-2">Contact Me</a>
            
        </div>
    </header>

    <main class="mt-24 px-2 flex-grow">
        @yield('content')
    </main>

    <footer class="p-4 text-center rounded-t-sm">
        <p>{{ get_setting('footer_text') ?? 'Copyright © 2024 Miftah. Made with love in' }} <span class="text-gray-700 font-bold tracking-wider">Cianjur</span></p>
    </footer>

    @vite('resources/js/app.js')
    @stack('script')
    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('menu-toggle');
            const menu = document.getElementById('mobile-menu');

            toggleButton.addEventListener('click', function () {
                menu.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>

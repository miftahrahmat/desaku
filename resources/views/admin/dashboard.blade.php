@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Article Analysis Dashboard</h2>

    <!-- Grid Layout for Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Total Articles -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 shadow-lg rounded-lg text-white">
            <div class="flex items-center">
                <div class="mr-4">
                    <!-- Ikon Total Articles -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl">Total Articles</h3>
                    <p class="text-3xl font-semibold">{{ $totalArticles }}</p>
                </div>
            </div>
        </div>

        <!-- Longest Article -->
        <div class="bg-gradient-to-r from-green-400 to-teal-500 p-6 shadow-lg rounded-lg text-white">
            <div class="flex items-center">
                <div class="mr-4">
                    <!-- Ikon Longest Article -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6-8h6m2 10a9 9 0 100-18 9 9 0 000 18z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl">Total Users</h3>
                    <p class="text-2xl font-semibold">{{ $userCount }}</p>
                </div>
            </div>
        </div>

        <!-- Most Commented Article -->
        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-6 shadow-lg rounded-lg text-white">
            <div class="flex items-center">
                <div class="mr-4">
                    <!-- Ikon Most Commented Article -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2m-4 0H7m4 0v4m0-16h-2m4 0h-4m4 0h-4m0 0H7m4-2v4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl">Most Commented Article</h3>
                    <p class="text-2xl font-semibold">{{ $mostCommentedArticle->title }}</p>
                    <p>Comments: {{ $mostCommentedArticle->comments_count }}</p>
                </div>
            </div>
        </div>

        <!-- Most Viewed Article -->
        <div class="bg-gradient-to-r from-red-500 to-pink-600 p-6 shadow-lg rounded-lg text-white">
            <div class="flex items-center">
                <div class="mr-4">
                    <!-- Ikon Most Viewed Article -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl">Most Viewed Article</h3>
                    <p class="text-2xl font-semibold">{{ $mostViewedArticle->title }}</p>
                    <p>Views: {{ $mostViewedArticle->views }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

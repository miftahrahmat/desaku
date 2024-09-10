@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex items-center justify-center bg-gray-50 dark:bg-gray-900">
    <div class="max-w-md w-full space-y-4 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
        @if(session('error'))
        <div class="w-full p-4 mb-4 text-red-700 bg-red-100 border border-red-200 rounded-lg">
            {{ session('error') }}
        </div>
        @endif
        <div class="text-center">
            <h2 class="text-2xl font-bold">Login to Your Account</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Please login using your credentials.
            </p>
        </div>
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-4 w-4 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-200">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Log in
                </button>
            </div>

            <!-- Forgot Password -->
            <div class="text-center">
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400"
                       href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

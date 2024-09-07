@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="flex items-center justify-center bg-gray-50 dark:bg-gray-900">
    <div class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
        <div class="text-center">
            <h2 class="text-2xl font-bold">Create Your Account</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Please fill the form to create your account.
            </p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-200">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

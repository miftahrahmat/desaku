@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center bg-gray-50 dark:bg-gray-900">
    <div class="max-w-md w-full space-y-4 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
        
        <div class="text-center">
            <h2 class="text-2xl font-bold">Reset Password</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Please inpu your email.
            </p>
        </div>

        @if(session('error'))
        <div class="w-full p-4 mb-4 text-red-700 bg-red-100 border border-red-200 rounded-lg">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                    class="mt-1 block w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-4">
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Send Password Reset Link
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

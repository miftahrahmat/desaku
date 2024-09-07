@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <h2 class="text-2xl font-bold mb-4">Manage Articles</h2>
        <a href="{{ route('admin.posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block hover:bg-blue-600">Create New Article</a>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Slug</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Excerpt</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Author</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Published At</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($posts as $post)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $post->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $post->slug }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($post->excerpt, 50) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $post->author->name }}</td>
                            <td class="px-2 py-4 text-sm text-gray-500">{{ $post->published_at ? $post->published_at->format('M d, Y') : '-' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-600 hover:underline mr-2">
                                    Edit
                                </a>
                                <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

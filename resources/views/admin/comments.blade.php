@extends('layouts.admin')

@section('css')
    <!-- Tambahkan CSS khusus jika diperlukan -->
@endsection

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-6">Manage Komentar</h1>

        <!-- Tabel untuk menampilkan komentar -->
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Post ID</th>
                    <th class="py-2 px-4 border-b">User ID</th>
                    <th class="py-2 px-4 border-b">Guest Name</th>
                    <th class="py-2 px-4 border-b">Guest Email</th>
                    <th class="py-2 px-4 border-b">Body</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $comment->post_id }}</td>
                        <td class="py-2 px-4 border-b">{{ $comment->user_id ?? 'Guest' }}</td>
                        <td class="py-2 px-4 border-b">{{ $comment->guest_name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $comment->guest_email ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ Str::limit($comment->body, 50) }}</td>
                        <td class="py-2 px-4 border-b">
                            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded-md">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $comments->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Tambahkan script jika diperlukan -->
@endpush

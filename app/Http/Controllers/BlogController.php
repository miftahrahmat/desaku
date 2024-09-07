<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::whereNotNull('published_at')->orderBy('published_at', 'desc')->paginate(6);
        $tags = Tag::all();

        // Ambil artikel terbaru sebagai featured post
        $featuredPost = Post::orderBy('published_at', 'desc')->first();

        // Ambil semua kategori untuk dropdown kategori
        $categories = Category::all();

        return view('blogs.index', compact('featuredPost', 'posts', 'categories', 'tags'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->whereNotNull('published_at')->orderBy('published_at', 'desc')->paginate(9);
        $categories = Category::all();
        $tags = Tag::all();
        $featuredPost = Post::orderBy('published_at', 'desc')->first();

        return view('blogs.index', compact('featuredPost', 'posts', 'categories', 'tags'))->with('currentCategory', $category);
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->whereNotNull('published_at')->orderBy('published_at', 'desc')->paginate(9);
        $categories = Category::all();
        $tags = Tag::all();
        // Ambil artikel terbaru sebagai featured post
        $featuredPost = Post::orderBy('published_at', 'desc')->first();

        return view('blogs.index', compact('featuredPost', 'posts', 'categories', 'tags'))->with('currentTag', $tag);
    }

    public function show($slug) {
        $post = Post::with('tags')->where('slug', $slug)->firstOrFail();

        // Session key untuk menyimpan artikel yang telah dilihat
        $sessionKey = 'viewed_posts_' . $post->id;

        // Cek apakah artikel sudah pernah dilihat oleh pengguna
        if (!Session::has($sessionKey)) {
            // Tambah views jika belum dilihat dalam session
            $post->increment('views');

            // Simpan di session dan atur waktu expired (misal 1 jam)
            Session::put($sessionKey, true);
            Session::put($sessionKey.'_time', now()->addHour());
        } else {
            // Jika waktu expired sudah lewat, tambahkan views lagi dan reset cache
            $cacheTime = Session::get($sessionKey.'_time');
            if (now()->greaterThan($cacheTime)) {
                $post->increment('views');
                Session::put($sessionKey.'_time', now()->addHour());
            }
        }
        // Ambil semua komentar untuk post ini dengan balasannya
        $comments = Comment::where('post_id', $post->id)
        ->whereNull('parent_id') // Hanya ambil komentar induk
        ->with(['replies', 'user']) // Ambil balasan dan pengguna terdaftar (jika ada)
        ->get();

        // Ambil artikel terkait berdasarkan kategori atau tags yang sama
        $relatedPosts = Post::whereHas('categories', function ($query) use ($post) {
            return $query->whereIn('categories.id', $post->categories->pluck('id')); // Prefix 'categories.id'
        })
        ->orWhereHas('tags', function ($query) use ($post) {
            return $query->whereIn('tags.id', $post->tags->pluck('id')); // Prefix 'tags.id'
        })
        ->where('posts.id', '!=', $post->id) // Prefix 'posts.id'
        ->take(5) // Ambil 5 artikel terkait
        ->get();

        return view('blogs.show', compact('post', 'comments', 'relatedPosts'));
    }

    public function store(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);

        // Jika pengguna tidak terdaftar, gunakan guest_name dan guest_email
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->body = $request->body;

        if (auth()->check()) {
            $comment->user_id = auth()->id();
        } else {
            $comment->guest_name = $request->guest_name;
            $comment->guest_email = $request->guest_email;
        }

        $comment->save();

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function reply(Request $request, $komenId)
    {
        $cekKomen = Comment::findOrFail($komenId);
        $comment = new Comment();
        $comment->parent_id = $komenId;
        $comment->post_id = $cekKomen->post_id;
        $comment->body = $request->body;

        if (auth()->check()) {
            $comment->user_id = auth()->id();
        } else {
            $comment->guest_name = $request->guest_name;
            $comment->guest_email = $request->guest_email;
        }

        $comment->save();

        return redirect()->back()->with('success', 'Berhasil membalas komentar!');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('query');

        // Cari artikel berdasarkan judul atau konten yang sesuai dengan query pencarian
        $posts = Post::where('title', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('body', 'LIKE', "%{$searchQuery}%")
                    ->paginate(10);

        return view('blogs.search', compact('posts', 'searchQuery'));
    }

}

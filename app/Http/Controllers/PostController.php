<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DOMDocument;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function adminIndex()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $authors = User::where('role', 'admin')->get();
        $tags = Tag::all();
        $categories = Category::all();

        return view('admin.posts.create', compact('authors', 'categories', 'tags'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'excerpt' => 'required|string|max:250',
            'body' => 'required',
            'image' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'published_at' => 'required|date',
            'categories' => 'required|array',
            'tags' => 'required|array'
        ]);

        // Simpan data post ke dalam tabel posts
        $post = Post::create([
            'title' => $request->title,
            'slug' => $this->generateUniqueSlug($request->title),
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'gambar' => $request->image,
            'author_id' => $request->author_id,
            'published_at' => $request->published_at
        ]);

        // Proses kategori
        $categoryIds = [];
        foreach ($request->categories as $categoryName) {
            $categorySlug = Str::slug($categoryName); // Buat slug dari nama kategori
            $category = Category::firstOrCreate( // Cari atau buat kategori baru
                ['slug' => $categorySlug],
                ['name' => $categoryName, 'slug' => $categorySlug]
            );
            $categoryIds[] = $category->id; // Simpan ID kategori untuk digunakan pada attach
        }
        
        $post->categories()->attach($categoryIds); // Hubungkan kategori dengan post

        // Proses tags
        $tagIds = [];
        foreach ($request->tags as $tagName) {
            $tagSlug = Str::slug($tagName); // Buat slug dari nama tag
            $tag = Tag::firstOrCreate( // Cari atau buat tag baru
                ['slug' => $tagSlug],
                ['name' => $tagName, 'slug' => $tagSlug]
            );
            $tagIds[] = $tag->id; // Simpan ID tag untuk digunakan pada attach
        }
        
        $post->tags()->attach($tagIds); // Hubungkan tag dengan post

        return redirect()->route('admin.posts.index')->with('success', 'Article created successfully.');
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,'.$post->id,
            'excerpt' => 'required|string|max:255',
            'body' => 'required',
            'image' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'published_at' => 'required|date',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id'
        ]);

        // Hapus gambar lama jika ada perubahan gambar
        if ($request->image !== $post->gambar) {
            Storage::delete($post->gambar);  // Hapus gambar lama dari storage
        }

        // Update post
        $post->update([
            'title' => $request->title,
            'slug' => $this->generateUniqueSlug($request->title, $post->id),
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'gambar' => $request->image,
            'author_id' => $request->author_id,
            'published_at' => $request->published_at,
        ]);

        // Update kategori dan tag terkait
        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        return redirect()->route('admin.posts.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Post $post)
    {
        // Hapus gambar utama dari storage
        Storage::delete($post->gambar);

        // Hapus semua gambar yang ada di dalam body post
        $dom = new DOMDocument();
        @$dom->loadHTML($post->body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // Pastikan URL yang dimulai dengan 'storage/' dihapus dari penyimpanan
            if (strpos($src, 'storage/') !== false) {
                $path = str_replace(url('/') . '/storage/', '', $src);
                Storage::delete('public/' . $path);
            }
        }

        // Hapus post dari database
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Article deleted successfully.');
    }

    /**
     * Generate a unique slug for a post.
     *
     * @param  string  $title
     * @return string
     */
    private function generateUniqueSlug($title)
    {
        // Slugify title
        $slug = Str::slug($title);

        // Check if the slug already exists in the posts table
        $count = Post::where('slug', 'LIKE', "{$slug}%")->count();

        // If slug already exists, append a unique number
        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function edit(Post $post)
    {
        $authors = User::where('role', 'admin')->get();
        $tags = Tag::all();
        $categories = Category::all();

        return view('admin.posts.edit', compact('post', 'tags', 'categories', 'authors'));
    }

    public function searchCategories(Request $request)
    {
        $query = $request->input('q');
        $categories = Category::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json($categories);
    }

    public function searchTags(Request $request)
    {
        $query = $request->input('q');
        $tags = Tag::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json($tags);
    }

}

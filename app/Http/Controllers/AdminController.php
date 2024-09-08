<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Data untuk ditampilkan di dashboard
        // Mengambil semua artikel
        $posts = Post::all();

        $totalArticles = Post::count();
        $userCount = User::count();

        // Metrik 2: Artikel dengan jumlah kata terbanyak
        $longestArticle = $posts->map(function($post) {
            return ['post' => $post, 'word_count' => str_word_count($post->content)];
        })->sortByDesc('word_count')->first();

        // Metrik 3: Artikel paling sering dikomentari
        $mostCommentedArticle = Post::withCount('comments')->orderBy('comments_count', 'desc')->first();

        // Metrik 4: Artikel paling banyak dilihat (kalau ada fitur views di tabel posts)
        $mostViewedArticle = Post::orderBy('views', 'desc')->first();  // Anggap ada kolom views
        
        return view('admin.dashboard', compact('totalArticles', 'userCount', 'longestArticle', 'mostCommentedArticle', 'mostViewedArticle'));
    }

    public function profile()
    {
        $user = Auth::user();
        $code = Str::random(5);

        return view('admin.profile', compact('user', 'code'));
    }

    /**
     * Proses update profil admin.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->has('profile_tab')) {
            // Validasi input untuk Profile Tab
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'avatar' => 'nullable|string',
            ]);

            // Update data user
            $user->avatar = $request->avatar;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return redirect()->back()->with('success', 'Profile updated successfully.');
        }

        if ($request->has('settings_tab')) {
            $request->validate([
                'website_name' => 'required|string|max:255',
                'website_icon' => 'nullable|string',
                'footer_text' => 'nullable|string|max:1000',
            ]);

            set_setting('website_name', $request->website_name);
            set_setting('footer_text', $request->footer_text);
            set_setting('website_icon', $request->website_icon);

            return redirect()->back()->with('success', 'Settings updated successfully.');
        }

        if ($request->has('security_tab')) {
            // Validasi input untuk Security Tab
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Update password user
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success', 'Password updated successfully.');
        }

        return redirect()->back()->with('error', 'Nothing to update.');
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('blogs.index');
});

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/categories/{slug}', [BlogController::class, 'category'])->name('blogs.category');
Route::get('/tags/{slug}', [BlogController::class, 'tag'])->name('blogs.tag');
Route::get('/blogs/{slug}', [BlogController::class, 'show']);
Route::post('/blogs/{id}/komentar', [BlogController::class, 'store'])->name('comments.store');
Route::post('/blogs/{id}/balas-komentar', [BlogController::class, 'reply'])->name('comments.reply');
Route::get('/search', [BlogController::class, 'search'])->name('posts.search');

Auth::routes();
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/admin/profile/update', [AdminController::class, 'update'])->name('admin.profile.update');

    // Manajemen artikel
    Route::get('/admin/posts', [PostController::class, 'adminIndex'])->name('admin.posts.index');
    Route::get('/admin/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('/admin/posts/store', [PostController::class, 'store'])->name('admin.posts.store');
    Route::get('/admin/posts/{post}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/admin/posts/{post}/update', [PostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/admin/posts/{post}/delete', [PostController::class, 'destroy'])->name('admin.posts.delete');

    Route::get('/api/categories/search', [PostController::class, 'searchCategories'])->name('api.categories.search');
    Route::get('/api/tags/search', [PostController::class, 'searchTags'])->name('api.tags.search');
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth', 'admin']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


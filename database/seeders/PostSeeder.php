<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Pastikan sudah ada kategori dan tag
        $categories = Category::all();
        $tags = Tag::all();

        Post::factory()->count(50)->create()->each(function ($post) use ($categories, $tags) {
            // Mengaitkan post dengan 1-3 kategori
            $post->categories()->attach($categories->random(rand(1, 3))->pluck('id')->toArray());

            // Mengaitkan post dengan 2-5 tag
            $post->tags()->attach($tags->random(rand(2, 5))->pluck('id')->toArray());
        });
    }
}

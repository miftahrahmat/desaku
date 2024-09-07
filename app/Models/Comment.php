<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'guest_name', 'guest_email', 'body', 'parent_id'];

    // Relasi ke post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relasi ke pengguna terdaftar
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi untuk balasan komentar
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Relasi untuk komentar induk
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}

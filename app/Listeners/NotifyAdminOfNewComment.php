<?php

namespace App\Listeners;

use App\Events\NewCommentAdded;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotifyAdminOfNewComment
{
    use InteractsWithQueue;

    public function handle(NewCommentAdded $event)
    {
        // Cek apakah notifikasi untuk komentar ini sudah ada di database
        $existingNotification = DB::table('notifications')
            ->where('notifiable_id', 1) // Ganti dengan admin ID
            ->where('type', NewCommentNotification::class)
            ->whereJsonContains('data->comment_id', $event->comment->id)
            ->exists();

        if ($existingNotification) {
            return;
        }

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewCommentNotification($event->comment));
        }
    }

}

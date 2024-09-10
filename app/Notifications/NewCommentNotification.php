<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        // Mengirim melalui email dan database
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Komentar Baru di Artikel ')
                    ->greeting('Halo, Admin!')
                    ->line('Ada komentar baru di artikel: ' . $this->comment->post->title)
                    ->line('Isi Komentar: "' . $this->comment->body . '"')
                    ->action('Lihat Komentar', url('/blogs/' . $this->comment->post->slug))
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    public function toArray($notifiable)
    {
        return [
            'comment_id' => $this->comment->id,
            'comment_body' => $this->comment->body,
            'article_id' => $this->comment->post->id,
            'article_title' => $this->comment->post->title,
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Sasaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;

    protected $comment;
    protected $sasaran;

    public function __construct($comment, Sasaran $sasaran)
    {
        $this->comment = $comment;
        $this->sasaran = $sasaran;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Komentar baru: ' . $this->comment->isi,
            'sasaran' => $this->sasaran->id,
        ];
    }
}

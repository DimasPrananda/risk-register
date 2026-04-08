<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SasaranNotification extends Notification
{
    use Queueable;

    protected $sasaran;
    protected $user;

    public function __construct($sasaran, $user)
    {
        $this->sasaran = $sasaran;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Sasaran baru ditambahkan oleh ' . $this->user->name,
            'sasaran' => $this->sasaran->id,
        ];
    }
}
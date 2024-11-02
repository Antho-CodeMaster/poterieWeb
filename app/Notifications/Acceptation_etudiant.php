<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Acceptation_etudiant extends Notification
{
    use Queueable;

    private $id_kiosque;

    /**
     * Create a new notification instance.
     */
    public function __construct($id_kiosque)
    {
        $this->id_kiosque = $id_kiosque;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Terracium | Votre demande a été acceptée!')
            ->markdown('mail.acceptation-etudiant', ['id' => $this->id_kiosque]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class Demande_renouvellement extends Notification
{
    use Queueable;
    private $date;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->date = Carbon::now()->addMonth()->locale('fr_FR')->isoFormat('dddd [le] D MMMM YYYY');
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
            ->subject('Terracium | Vous avez un mois pour renouveler votre abonnement chez Terracium')
            ->markdown('mail.demande-renouvellement', ['date' => $this->date]);
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

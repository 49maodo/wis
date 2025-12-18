<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ?string $password
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Création de votre compte')
            ->greeting('Bonjour,')
            ->line('Votre compte a été créé avec succès.')
            ->line('Identifiant : ' . $notifiable->email)
            ->lineIf(!empty($this->password), 'Votre mot de passe est : ' . $this->password)
            ->line('Veuillez changer votre mot de passe après votre première connexion.')
            ->action('Se connecter', config('app.frontend_url') . '/login')
            ->salutation('Cordialement.');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}

<?php

namespace App\Notifications;

use App\Models\CompanyInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecruiterInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public CompanyInvitation $invitation
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->invitation->getInvitationUrl();
        $companyName = $this->invitation->compagny->name;
        $inviterName = $this->invitation->inviter->firstname . ' ' . $this->invitation->inviter->name;

        return (new MailMessage)
            ->subject("Invitation à rejoindre {$companyName}")
            ->greeting("Bonjour !")
            ->line("{$inviterName} vous invite à rejoindre l'équipe de recrutement de {$companyName}.")
            ->line("En acceptant cette invitation, vous pourrez publier des offres d'emploi et gérer les candidatures pour cette entreprise.")
            ->action('Accepter l\'invitation', $url)
            ->line("Cette invitation expirera le {$this->invitation->expires_at->format('d/m/Y à H:i')}.")
            ->line("Si vous n'avez pas demandé cette invitation, aucune action n'est requise.");
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}

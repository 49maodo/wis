<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationUpdateNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable): MailMessage
    {
        $statusMessages = [
            'accepted' => 'Félicitations ! Votre candidature a été acceptée.',
            'rejected' => 'Nous sommes désolés, votre candidature n\'a pas été retenue.',
            'pending' => 'Votre candidature est en cours d\'examen.'
        ];

        return (new MailMessage)
            ->subject('Mise à jour de votre candidature - ' . $this->application->job->title)
            ->greeting('Bonjour ' . $notifiable->firstname . ' ' . $notifiable->name)
            ->line('Votre candidature a été mise à jour.')
            ->line('Poste : ' . $this->application->job->title)
            ->line('Entreprise : ' . $this->application->job->recruiter->compagny->name)
            ->action('Voir votre candidature', config('app.frontend_url') . '/applications')
            ->line('Cordialement, l\'équipe WiS.');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'application_updated',
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'company_name' => $this->application->job->recruiter->compagny->name,
            'status' => $this->application->status,
            'message' => $this->getStatusMessage(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'application_updated',
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'company_name' => $this->application->job->recruiter->compagny->name,
            'status' => $this->application->status,
            'message' => $this->getStatusMessage(),
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'application_updated',
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'status' => $this->application->status,
        ];
    }

    private function getStatusMessage(): string
    {
        return match($this->application->status) {
            'accepted' => 'Votre candidature a été acceptée ! 🎉',
            'rejected' => 'Votre candidature n\'a pas été retenue.',
            'pending' => 'Votre candidature est en cours d\'examen.',
            default => 'Votre candidature a été mise à jour.'
        };
    }
}

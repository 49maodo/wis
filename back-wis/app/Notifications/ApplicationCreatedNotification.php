<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationCreatedNotification extends Notification implements ShouldQueue
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
        return (new MailMessage)
            ->subject('Candidature reçue - ' . $this->application->job->title)
            ->greeting('Bonjour ' . $notifiable->firstname . ' ' . $notifiable->name)
            ->line('Vous avez postulé à l\'offre : ' . $this->application->job->title)
            ->line(
                'Votre candidature a bien été transmise à ' .
                $this->application->job->recruiter->compagny->name .
                '.'
            )
            ->action(
                'Voir ma candidature',
                config('app.frontend_url') . '/applications'
            )
            ->salutation('Cordialement, l\'équipe WiS');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'application_created',
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'company_name' => $this->application->job->recruiter->compagny->name,
            'message' => 'Votre candidature a été envoyée avec succès.',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'application_created',
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'company_name' => $this->application->job->recruiter->compagny->name,
            'message' => 'Votre candidature a été envoyée avec succès.',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'application_created',
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
        ];
    }
}

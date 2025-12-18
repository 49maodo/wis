<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationReceivedNotification extends Notification implements ShouldQueue, ShouldBroadcast
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
            ->subject('Nouvelle candidature reçue - ' . $this->application->job->title)
            ->greeting('Bonjour ' . $notifiable->firstname . ' ' . $notifiable->name)
            ->line('Vous avez reçu une nouvelle candidature pour l\'offre : ' . $this->application->job->title)
            ->line('Candidat : ' . $this->application->candidat->firstname . ' ' . $this->application->candidat->name)
            ->action(
                'Voir la candidature',
                config('app.frontend_url') . '/recruiter/jobs/' . $this->application->job_id . '/applications'
            )
            ->salutation('Cordialement, l\'équipe WiS');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'new_application_received',
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'job_title' => $this->application->job->title,
            'candidat_name' => $this->application->candidat->firstname . ' ' . $this->application->candidat->name,
            'message' => 'Nouvelle candidature reçue',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'new_application_received',
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'job_title' => $this->application->job->title,
            'candidat_name' => $this->application->candidat->firstname . ' ' . $this->application->candidat->name,
            'message' => 'Nouvelle candidature reçue pour ' . $this->application->job->title,
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'new_application_received',
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
        ];
    }
}

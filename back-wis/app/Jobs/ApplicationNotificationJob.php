<?php

namespace App\Jobs;

use App\Models\Application;
use App\Notifications\ApplicationCreatedNotification;
use App\Notifications\ApplicationUpdateNotification;
use App\Notifications\NewApplicationReceivedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApplicationNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(public int $applicationId, public string $event)
    {
    }

    public function handle(): void
    {
        $application = Application::with([
            'candidat',
            "job",
            "job.recruiter",
            'job.recruiter.compagny',
            'candidat',
        ])->findOrFail($this->applicationId);
        if ($this->event === 'created'){
            $application->candidat->notify(new ApplicationCreatedNotification($application));
            // Notifier le recruteur
            $application->job->recruiter->notify(new NewApplicationReceivedNotification($application));

        } elseif ($this->event === 'updated') {
            $application->candidat->notify(new ApplicationUpdateNotification($application));
        }
    }
}

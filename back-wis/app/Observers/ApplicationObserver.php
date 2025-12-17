<?php

namespace App\Observers;

use App\Jobs\ApplicationNotificationJob;
use App\Models\Application;

class ApplicationObserver
{
    public function created(Application $application): void
    {
        ApplicationNotificationJob::dispatchAfterResponse($application->id, 'created');
    }

    public function updated(Application $application): void
    {
        ApplicationNotificationJob::dispatchAfterResponse($application->id, 'updated');
    }
}

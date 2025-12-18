<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserCredentialsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public ?string $plain_password
    ) {}

    public function handle(): void
    {
        $this->user->notify(
            new UserCreatedNotification($this->plain_password)
        );
    }
}

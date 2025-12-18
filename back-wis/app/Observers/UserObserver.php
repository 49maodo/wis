<?php

namespace App\Observers;

use App\Jobs\SendUserCredentialsJob;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public function creating(User $user): void
    {
        // Cas 1 : création via Filament (admin)
        if (\Filament\Facades\Filament::isServing()) {
            $plainPassword = Str::random(10);
            $user->password = Hash::make($plainPassword);
            // Stock temporaire pour notification
            $user->plain_password = $plainPassword;
        }
    }
    public function created(User $user): void
    {
        // Automatically create a profile when a user is created
        $user->profile()->create([
            'slug' => \Str::slug($user->firstname . ' ' . $user->name . '-' . uniqid()),
        ]);

        SendUserCredentialsJob::dispatchAfterResponse($user, $user->plain_password);
        unset($user->plain_password);
    }
}

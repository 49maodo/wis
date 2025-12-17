<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Observers\UserObserver;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    public ?string $plain_password = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'name',
        'email',
        'password',
        'phoneNumber',
        'role',
        'compagny_id',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
    ];

    public function compagny()
    {
        return $this->belongsTo(Compagny::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function activeSubscription()
    {
        return $this->hasMany(Subscription::class, 'recruiter_id','id')
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->first();
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'creatorId', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'recruiter_id', 'id');
    }

    // hasRole

    public function hasRole(UserRole $role): bool
    {
        return $this->role === $role;
    }


    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(UserRole::ADMIN);
    }
}

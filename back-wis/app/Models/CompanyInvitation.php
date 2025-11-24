<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CompanyInvitation extends Model
{
    protected $fillable = [
        'compagny_id',
        'invited_by',
        'email',
        'token',
        'expires_at',
        'accepted_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function compagny(): BelongsTo
    {
        return $this->belongsTo(Compagny::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Génère un token unique pour l'invitation
     */
    public static function generateToken(): string
    {
        do {
            $token = Str::random(64);
        } while (self::where('token', $token)->exists());

        return $token;
    }

    /**
     * Vérifie si l'invitation est toujours valide
     */
    public function isValid(): bool
    {
        return $this->accepted_at === null
            && $this->expires_at->isFuture();
    }

    /**
     * Vérifie si l'invitation a expiré
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Marque l'invitation comme acceptée
     */
    public function markAsAccepted(): void
    {
        $this->update([
            'accepted_at' => now(),
        ]);
    }

    public function markAsDeclined(): void
    {
        $this->update([
            'expires_at' => now(),
        ]);
    }

    /**
     * Obtient le lien d'invitation
     */
    public function getInvitationUrl(): string
    {
        return config('app.frontend_url') . '/accept-invitation?token=' . $this->token;
    }
}

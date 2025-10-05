<?php

namespace App\Models;

use App\Enums\VerificationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompagnyVerifications extends Model
{
    protected $fillable = [
        'compagny_id',
        'submitted_by',
        'status',
        'ninea',
        'rccm',
        'notes',
        'admin_notes',
    ];

    protected $casts = [
        'status' => VerificationStatus::class,
    ];

    public function compagny(): BelongsTo
    {
        return $this->belongsTo(Compagny::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}

<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'message',
        'cv',
        'status',
        'candidat_id',
        'job_id',
    ];
    protected $casts = [
        'status' => ApplicationStatus::class,
    ];

    public function candidat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}

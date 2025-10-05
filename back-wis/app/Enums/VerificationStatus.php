<?php

namespace App\Enums;

enum VerificationStatus: string
{
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case APPROVED = 'approved';
}

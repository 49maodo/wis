<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
}

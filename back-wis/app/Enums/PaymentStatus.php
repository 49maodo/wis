<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case REFUNDED = 'refunded';
}

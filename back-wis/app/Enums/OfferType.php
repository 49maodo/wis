<?php

namespace App\Enums;

enum OfferType: string
{
    case BASIC = 'basic';
    case PREMIUM = 'premium';
    case UNLIMITED = 'unlimited';
}

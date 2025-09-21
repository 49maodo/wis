<?php

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case RECRUITER = 'recruiter';
    case ADMIN = 'admin';
}

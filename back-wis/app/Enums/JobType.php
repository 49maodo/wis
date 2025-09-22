<?php

namespace App\Enums;

enum JobType: string
{
    case CDI = 'cdi';
    case CDD = 'cdd';
    case FREELANCE = 'freelance';
    case STAGE = 'stage';
    case ALTERNANCE = 'alternance';
    case Apprentissage = 'apprentissage';
    case VOCATATION = 'vocation';
}

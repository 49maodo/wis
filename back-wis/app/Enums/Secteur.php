<?php

namespace App\Enums;

enum Secteur: string
{
    case TELECOMMUNICATION = 'Télécommunication';
    case INFORMATIQUE = 'Informatique';
    case SANTE = 'Santé';
    case EDUCATION = 'Éducation';
    case FINANCE = 'Finance';
    case MARKETING = 'Marketing';
    case AGRICULTURE = 'Agriculture';
    case TOURISME = 'Tourisme';
    case TRANSPORT = 'Transport';
    case CONSTRUCTION = 'Construction';
    case ENERGIE = 'Énergie';
    case AUTRE = 'Autre';
}

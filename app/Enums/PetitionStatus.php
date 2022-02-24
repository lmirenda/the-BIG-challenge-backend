<?php

namespace App\Enums;

enum PetitionStatus: string
{
    case PENDING = 'pending';
    case TAKEN = 'in progress';
    case FINISHED = 'done';
}

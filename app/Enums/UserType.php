<?php

namespace App\Enums;

enum UserType: string
{
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
}

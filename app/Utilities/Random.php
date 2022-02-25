<?php

namespace App\Utilities;

use App\Enums\PetitionStatus;
use App\Enums\UserType;

class Random
{
    public static function userType(): string
    {
        $types = UserType::cases();
        $typePosition = array_rand($types);
        return $types[$typePosition]->value;
    }

    public static function petitionStatus(): string
    {
        $statuses = PetitionStatus::cases();
        $statusPosition = array_rand($statuses);
        return $statuses[$statusPosition]->value;
    }
}

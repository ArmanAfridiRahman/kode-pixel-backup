<?php

namespace App\Enums;

enum SubscriptionStatus: int
{
    use EnumTrait;

    case Running = 1;
    case Expired = 0;
    case Inactive = 2;

}
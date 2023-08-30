<?php

namespace App\Enums;

enum PlanDuration: string 
{
    use EnumTrait;

    case DAILY = '1';
    case WEEKLY = '7';
    case MONTHLY = '30';
    case SIX_MONTH = '180';
    case NINE_MONTH = '270';
    case YEARLY = '365';
    case UNLIMITED = 'unlimited';

}

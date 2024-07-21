<?php

namespace App\Enum;

enum Recipe: string
{
    case BREAKFAST = 'breakfast';
    case LUNCH = 'lunch';
    case DINNER = 'dinner';
    case SNACKS = 'snacks';
}
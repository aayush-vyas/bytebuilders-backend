<?php

namespace App\Enum;

enum RecipeEnum: string
{
    case BREAKFAST = 'breakfast';
    case LUNCH = 'lunch';
    case DINNER = 'dinner';
    case SNACKS = 'snacks';
}
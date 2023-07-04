<?php

namespace App\Enums;

enum GreetingStatusEnum: string
{
    case Ready = 'Готове до публікації';
    case Published = 'Опубліковане';
    case Inactive = 'Не готове до публікації';
    case Archived = 'Архівоване';
}

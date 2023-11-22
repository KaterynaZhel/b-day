<?php

namespace App\Enums;

enum VoteStatus: string
{
    case inProgress = "Триває";
    case finished = "Завершене";
}

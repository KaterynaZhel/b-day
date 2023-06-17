<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\QueryFilter;
use App\Models\Celebrant;
use Carbon\Carbon;

class CelebrantFilter extends QueryFilter
{
    public function lastname($lastname)
    {
        return $this->builder->where('lastname', 'like', "%{$lastname}%");
    }

    public function firstname($firstname)
    {
        return $this->builder->where('firstname', 'like', "%{$firstname}%");
    }

    public function position($position)
    {
        return $this->builder->where('position', 'like', "%{$position}%");
    }

    public function birthday($birthday)
    {
        return $this->builder->where('birthday', 'like', "%{$birthday}%");
    }

    public function birthdayBetweenDate($dayFrom, $dayTo)
    {
        return $this->builder->whereBetween('birthday', [$dayFrom, $dayTo]);
    }
}

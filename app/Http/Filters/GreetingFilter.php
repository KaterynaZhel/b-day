<?php

namespace App\Http\Filters;

use App\Casts\CelebrantPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GreetingFilter extends Filter
{
    /**
     * Filter friends by specified name.

     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function nameFriend(string $nameFriend = null): Builder
    {

        if (mb_strlen($nameFriend) >= 3) {
            return $this->builder->where('name', 'like', "%$nameFriend%");
        }

        return $this->builder;
    }

    /**
     
     
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function publicationDateFrom(string $publicationDateFrom = null): Builder
    {

        if ($publicationDateFrom) {
            return $this->builder->where(DB::raw('DATE(greetings.created_at)'), '>=', $publicationDateFrom);
        }

        return $this->builder;
    }

    /**
     
     
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function publicationDateTo(string $publicationDateTo = null): Builder
    {
        return $this->builder->where(DB::raw('DATE(greetings.created_at)'), '<=', $publicationDateTo);

    }


}
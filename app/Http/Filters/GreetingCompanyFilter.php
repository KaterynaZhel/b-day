<?php

namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


class GreetingCompanyFilter extends Filter
{
    /**
     
        * @param  string|null  $value
        * @return \Illuminate\Database\Eloquent\Builder
     */
    public function nameCelebrant(string $nameCelebrant = null): Builder
    {

        if (mb_strlen($nameCelebrant) >= 3) {
            return $this->builder
                ->where(function (Builder $query) use ($nameCelebrant) {
                    $query->where('celebrants.firstname', 'like', "$nameCelebrant%")
                        ->orWhere('celebrants.lastname', 'like', "$nameCelebrant%");
                });
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
            return $this->builder->where(DB::raw('DATE(greeting_companies.publish_at)'), '>=', $publicationDateFrom);
        }

        return $this->builder;
    }

    /**
     
     
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function publicationDateTo(string $publicationDateTo = null): Builder
    {
        return $this->builder->where(DB::raw('DATE(greeting_companies.publish_at)'), '<=', $publicationDateTo);

    }


}
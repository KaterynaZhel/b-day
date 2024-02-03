<?php

namespace App\Http\Filters;

use App\Casts\CelebrantPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CelebrantFilter extends Filter
{
    /**
     * Filter the Celebrants by the given firstname.
     *
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function firstname(string $firstname = null): Builder
    {
        return $this->builder->where('firstname', 'like', "%$firstname%");
    }

    /**
     * Filter the Celebrants by the given lastname.
     *
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function lastname(string $lastname = null): Builder
    {
        return $this->builder->where('lastname', 'like', "%$lastname%");
    }

    /**
     * Filter the Celebrants by the given position.
     *
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function position(string $position = null): Builder
    {
        return $this->builder->where('position', array_search($position, CelebrantPosition::$positions));
    }

    /**
     * Filter the Celebrants by the given birthday.
     *
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function birthday(string $birthday = null): Builder
    {
        return $this->builder->where('birthday', 'like', "%$birthday%");
    }

    /**
     * Filter the Celebrants by the given birthdayFrom.
     *
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function birthdayFrom(string $birthdayFrom = null): Builder
    {
        return $this->builder->where('birthday', '>=', $birthdayFrom);
    }

    /**
     * Filter the Celebrants by the given birthdayTo.
     *
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function birthdayTo(string $birthdayTo = null): Builder
    {
        return $this->builder->where('birthday', '<=', $birthdayTo);
    }

    /**
     * Filter the Celebrants by the given monthFrom.
     *
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function monthFrom(string $monthFrom = null): Builder
    {
        return $this->builder->whereMonth('birthday', '>=', $monthFrom);
    }

    /**
     * Filter the Celebrants by the given monthTo.
     *
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function monthTo(string $monthTo = null): Builder
    {
        return $this->builder->whereMonth('birthday', '<=', $monthTo);
    }

    /**
     * Filter the Celebrants by the given dayFrom.
     *
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function dayFrom(string $dayFrom = null): Builder
    {
        return $this->builder->whereDay('birthday', '>=', $dayFrom);
    }

    /**
     * Filter the Celebrants by the given dayTo.
     *
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function dayTo(string $dayTo = null): Builder
    {
        return $this->builder->whereDay('birthday', '<=', $dayTo);
    }

    /**
     * Filter the Celebrants by the given firstname.
     *
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function name(string $name = null): Builder
    {

        if (mb_strlen($name) >= 3) {
            return $this->builder
                ->where(function (Builder $query) use ($name) {
                    $query->where('firstname', 'like', "$name%")
                        ->orWhere('lastname', 'like', "$name%");
                });
        }
        return $this->builder;

    }

    /**
     * //Filter celebrants with birthdays in range date(disregarding year).
     *
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function birthdayRange(string $range = null): Builder
    {
        list($dateFrom, $dateTo) = explode("-", $range);

        //add 2020 (any leap year) so that the following list of dates can be generated
        $dateFromWithYear = Carbon::parse($dateFrom . '.2020');
        $dateToWithYear   = Carbon::parse($dateTo . '.2020');

        if ($dateFromWithYear->greaterThan($dateToWithYear)) {
            $dateFromWithYear->subYear();
        }
        $dates = Carbon::parse($dateFromWithYear)->daysUntil(Carbon::parse($dateToWithYear));

        $newDates = [];
        foreach ($dates as $date) {
            $newDates[] = $date->format('m-d');

        }

        return $this->builder->whereIn(
            DB::raw("DATE_FORMAT(birthday,'%m-%d')"),
            $newDates
        );

    }

    // Filter celebrants with birthdays in the coming days.
    public function nearestBirthdays(int $number_days = null): Builder
    {
        $next_week    = [];
        $current_date = Carbon::now();
        for ($i = 0; $i <= $number_days; $i++) {
            $next_week[] = $current_date->copy()->addDays($i)->format('m-d');
        }

        return $this->builder->whereIn(
            DB::raw("DATE_FORMAT(birthday,'%m-%d')"),
            $next_week
        );
    }
}
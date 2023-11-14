<?php

namespace App\Http\Filters;

use App\Models\Celebrant;
use Illuminate\Database\Eloquent\Builder;

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
        return $this->builder->where('position', 'like', "%$position%");
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
        return $this->builder->where('birthday', '>=', $birthdayFrom);;
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
}
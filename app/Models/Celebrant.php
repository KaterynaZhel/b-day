<?php

namespace App\Models;

use App\Casts\CelebrantPhoto;
use App\Casts\CelebrantPosition;
use App\Concerns\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Celebrant extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = ['lastname', 'firstname', 'middlename', 'birthday', 'email', 'company_id', 'position', 'user_id'];

    protected $casts = [
        'position' => CelebrantPosition::class,
        'photo' => CelebrantPhoto::class,
    ];

    public function greetingsCompany(): HasMany
    {
        return $this->hasMany(GreetingCompany::class);
    }

    public function lastGreetingsCompany(): HasOne
    {
        return $this->hasOne(GreetingCompany::class)->latest();
    }

    public function isHasNewGreetingCompany()
    {
        if (empty($this->lastGreetingsCompany)) {
            return false;
        }
        $dateNow = Carbon::now()->startOfDay();
        return Carbon::create($this->lastGreetingsCompany->publish_at)->gte($dateNow);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function hobbies(): BelongsToMany
    {
        return $this->belongsToMany(Hobby::class, 'hobby_celebrant', 'celebrant_id', 'hobby_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFindByCompany(Builder $query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }

    public function scopeNearestBirthdays(Builder $query, $daysAhead = 10)
    {
        // Calculate today's date
        $today = Carbon::now();

        // Calculate the date seven days from today
        $targetDate = $today->copy()->addDays($daysAhead);

        return $query
            ->whereMonth('birthday', '=', $today->month)
            ->whereDay('birthday', '>=', $today->day)
            ->orWhere(function ($query) use ($today, $targetDate) {
                $query->whereMonth('birthday', '=', $targetDate->month)
                    ->whereDay('birthday', '<=', $targetDate->day);
            })
            ->orderByRaw("DAYOFYEAR(birthday) ASC");
    }
}
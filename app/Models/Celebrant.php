<?php

namespace App\Models;

use App\Casts\CelebrantPhoto;
use App\Casts\CelebrantPosition;
use App\Concerns\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Celebrant extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = ['lastname', 'firstname', 'middlename', 'birthday', 'company_id', 'position'];

    protected $casts = [
        'position' => CelebrantPosition::class,
        'photo' => CelebrantPhoto::class,
    ];

    public function greetingsCompany()
    {
        return $this->hasMany(GreetingCompany::class);
    }

    public function lastGreetingsCompany()
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function hobbies()
    {
        return $this->belongsToMany(Hobby::class, 'hobby_celebrant', 'celebrant_id', 'hobby_id');
    }
}
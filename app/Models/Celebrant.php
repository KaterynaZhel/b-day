<?php

namespace App\Models;

use App\Casts\CelebrantPhoto;
use App\Casts\CelebrantPosition;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celebrant extends Model
{
    use HasFactory;
    protected $fillable = ['lastname', 'firstname', 'middlename', 'birthday', 'position'];

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

        return Carbon::create($this->lastGreetingsCompany->publish_at)->gte(Carbon::now());
    }
}
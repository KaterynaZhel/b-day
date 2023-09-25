<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Celebrant;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'site'];

    public function celebrants(): HasMany
    {
        return $this->hasMany(Celebrant::class, 'company_id', 'id');
    }

    public function greetingsCompany(): HasMany
    {
        return $this->hasMany(GreetingCompany::class, 'company_id', 'id');
    }
}

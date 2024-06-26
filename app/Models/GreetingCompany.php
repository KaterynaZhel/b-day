<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use App\Concerns\Filterable;

class GreetingCompany extends Model
{
    use HasFactory;
    use Filterable;
    protected $fillable = ['message_company', 'celebrant_id', 'company_id'];


    public function celebrant(): BelongsTo
    {
        return $this->belongsTo(Celebrant::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeFindByCompany(Builder $query)
    {
        return $query->where('greeting_companies.company_id', '=', Auth::user()->company_id);
    }
}

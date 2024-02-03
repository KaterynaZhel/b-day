<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class GreetingCompany extends Model
{
    use HasFactory;
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
        return $query->where('company_id', '=', Auth::user()->company_id);
    }
}

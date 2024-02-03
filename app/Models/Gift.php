<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'link', 'picture', 'celebrant_id', 'price', 'vote_id'];

    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }

    public function voting_results(): HasMany
    {
        return $this->hasMany(VotingResult::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VotingResult extends Model
{
    use HasFactory;

    protected $fillable = ['celebrant_id', 'gift_id', 'vote_id'];

    public function celebrant(): BelongsTo
    {
        return $this->belongsTo(Celebrant::class);
    }

    public function gift(): BelongsTo
    {
        return $this->belongsTo(Gift::class);
    }

    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }
}

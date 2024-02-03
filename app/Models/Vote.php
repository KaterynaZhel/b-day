<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['celebrant_id', 'votes_count', 'emails_sent'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function celebrant(): BelongsTo
    {
        return $this->belongsTo(Celebrant::class);
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class);
    }

    public function voting_results(): HasMany
    {
        return $this->hasMany(VotingResult::class);
    }

    public function getTopVotedGifts($vote_id)
    {
        $giftResults = $this->voting_results()
            ->where('vote_id', $vote_id)
            ->with('gift')
            ->get();

        // Count votes for each gift
        $giftVotes = $giftResults->groupBy('gift_id')->map->count();

        // Find the maximum number of votes
        $maxVotes = $giftVotes->max();

        // Filter gifts with maximum votes and get their details
        $topGiftDetails = $giftResults->filter(function ($giftResult) use ($maxVotes, $giftVotes) {
            return $giftVotes[$giftResult->gift_id] === $maxVotes;
        })->unique('gift_id')->map(fn ($giftResult) => [
            'gift_id' => $giftResult->gift->id,
            'gift_title' => $giftResult->gift->title,
        ])->values();

        return $topGiftDetails->values();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\VoteStatus;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['celebrant_id', 'gift_id', 'votes_count'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => VoteStatus::class,
    ];

    public function celebrant(): BelongsTo
    {
        return $this->belongsTo(Celebrant::class);
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'link', 'celebrant_id'];

    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }
}

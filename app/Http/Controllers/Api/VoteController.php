<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoteResource;
use App\Models\Vote;


class VoteController extends Controller
{

    public function show(string $hash)
    {
        $votingHash = substr($hash, 64);
        $vote       = Vote::where('hash', $votingHash)->first();
        return new VoteResource($vote);
    }
}

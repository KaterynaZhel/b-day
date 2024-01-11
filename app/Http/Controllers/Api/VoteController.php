<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResources\GiftResource;
use App\Http\Resources\VoteResource;
use App\Models\Vote;



class VoteController extends Controller
{

    public function statistics(string $hash)
    {
        $votingHash = substr($hash, 64);
        $vote       = Vote::where('hash', $votingHash)->first();

        $gifts = $vote->gifts()
            ->withCount('voting_results')
            ->orderByDesc('voting_results_count')
            ->get();

        return GiftResource::collection($gifts);
    }

    public function show(string $hash)
    {
        $votingHash = substr($hash, 64);
        $vote       = Vote::where('hash', $votingHash)->first();
        return new VoteResource($vote);
    }
}

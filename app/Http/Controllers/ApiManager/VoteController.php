<?php

namespace App\Http\Controllers\ApiManager;

use App\Enums\VoteStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Http\Resources\ManagerResources\VoteResource;
use App\Models\Celebrant;
use App\Models\Gift;
use App\Models\Vote;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    const RANDOM_HASH_LENGTH = 32;

    /**
     * Store a newly created resource in storage.
     */
    public function store(VoteRequest $request, $celebrant_id)
    {
        $gifts = Gift::where('celebrant_id', $celebrant_id)->get();
        $vote = Vote::create($request->all() + ['celebrant_id' => $celebrant_id]);
        $vote->start_at = now();
        $vote->end_at = now()->addDay();
        $vote->status = VoteStatus::inProgress;

        // Associate each gift with the vote
        foreach ($gifts as $gift) {
            $gift->vote_id = $vote->id;
            $gift->save();
        }

        // Generate a unique hash for the link using Hash facade (different hash for each id) for Vote
        $hash = Str::random(self::RANDOM_HASH_LENGTH);
        $vote->hash = $hash;
        $vote->save();

        // Generate a unique hash for the link using Hash facade (different hash for each email) for Celebrants
        $celebrants = Celebrant::findByCompany()->get();
        foreach ($celebrants as $celebrant) {
            $email = $celebrant->email;
            $celebrant->hash = hash('sha256', $email);
            $celebrant->save();
        }

        return (new VoteResource($vote))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}

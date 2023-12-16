<?php

namespace App\Http\Controllers\ApiManager;

use App\Enums\VoteStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Http\Resources\ManagerResources\VoteResource;
use App\Models\Celebrant;
use App\Models\Gift;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VoteController extends Controller
{
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

        // Generate a unique hash for the link using Hash facade (different hash for each email).
        $celebrant = Celebrant::findOrFail($celebrant_id);
        $email = $celebrant->email;
        $hash = Hash::make($email);
        $vote->hash = $hash;
        $vote->save();

        return (new VoteResource($vote))->response()->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED);
    }
}

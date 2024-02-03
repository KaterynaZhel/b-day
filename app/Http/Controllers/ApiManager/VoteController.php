<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Http\Resources\ManagerResources\VoteResource;
use App\Http\Resources\ManagerResources\VoteStatisticsResourceIndex;
use App\Models\Celebrant;
use App\Models\Gift;
use App\Models\Vote;
use App\Models\VotingResult;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    const RANDOM_HASH_LENGTH = 32;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Celebrant::findByCompany()->value('company_id');

        // Retrieve votes for Celebrant only for the current company
        $votes = Vote::with('celebrant')
            ->whereHas('celebrant', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->orderByDesc('id')
            ->paginate(11);

        // Iterate through the retrieved votes and update the votes_count
        foreach ($votes as $vote) {
            $voted = VotingResult::where('vote_id', $vote->id)->count();
            $vote->update(['votes_count' => $voted]);
        }

        return VoteStatisticsResourceIndex::collection($votes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VoteRequest $request, $celebrant_id)
    {
        // Get the selected gift IDs from the request
        $selectedGiftIds = $request->input('selected_gifts', []);

        // Get only the selected gifts based on their IDs
        $gifts = Gift::where('celebrant_id', $celebrant_id)
            ->whereIn('id', $selectedGiftIds)
            ->get();

        $vote = Vote::create($request->all() + ['celebrant_id' => $celebrant_id]);
        $vote->start_at = now();
        $vote->end_at = now()->addDay();

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
        // dd($celebrants);
        foreach ($celebrants as $celebrant) {
            $email = $celebrant->email;
            $celebrant->hash = hash('sha256', $email);
            $celebrant->save();
        }

        return (new VoteResource($vote))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}

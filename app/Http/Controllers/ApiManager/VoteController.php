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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VoteRequest $request, $celebrant_id)
    {
        $celebrant = Celebrant::where('company_id', '=', Auth::user()->company_id)->findOrFail($celebrant_id);
        $gifts = Gift::where('celebrant_id', $celebrant_id)->get();
        $vote = Vote::create($request->all() + ['celebrant_id' => $celebrant_id]);
        $vote->start_at = now();
        $vote->end_at = now()->addDay();
        $vote->status = VoteStatus::inProgress;
        $vote->celebrant_id = $celebrant->id;

        // Associate each gift with the vote
        foreach ($gifts as $gift) {
            $gift->vote_id = $vote->id;
            $gift->save();
        }

        // Generate a unique hash for the link using Hash facade
        $hash = Hash::make($vote->id . $vote->celebrant_id);
        $vote->hash = $hash;
        $vote->save();

        return (new VoteResource($vote))->response()->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResources\GiftResource;
use App\Http\Resources\VoteResource;
use App\Models\Vote;
use Illuminate\Http\Request;
use App\Models\Celebrant;
use App\Models\VotingResult;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

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

    public function voting(Request $request, string $hash)
    {
        try {
            // Extracting the last 32 characters as the voting hash
            $votingHash   = substr($hash, -32);
            $vote         = Vote::where('hash', $votingHash)->firstOrFail();

            // Extracting the first 64 characters as the employee hash
            $employeeHash = substr($hash, 0, 64);
            $employee     = Celebrant::where('hash', $employeeHash)->firstOrFail();

            // Return 404 if the celebrant is not found
            if (!$employee) {
                abort(404);
            }

            // Check if the celebrant has already voted
            if ($this->hasAlreadyVoted($employee, $vote)) {
                return response()->json(['error' => 'You have already voted.'], 422);
            }

            // Validate the gift_id
            $request->validate([
                'gift_id' => 'required|numeric|exists:gifts,id',
            ]);

            $votingResult = new VotingResult();
            $votingResult->celebrant_id = $employee->id;
            $votingResult->gift_id = $request->input('gift_id');
            $votingResult->vote_id = $vote->id;
            $votingResult->save();

            return response()->json(['message' => 'Vote recorded successfully.']);
        } catch (ModelNotFoundException $e) {
            Log::error('Record not found: ' . $e->getMessage());
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }

    private function hasAlreadyVoted($celebrant, $vote)
    {
        return VotingResult::where('celebrant_id', $celebrant->id)
            ->where('vote_id', $vote->id)
            ->exists();
    }
}

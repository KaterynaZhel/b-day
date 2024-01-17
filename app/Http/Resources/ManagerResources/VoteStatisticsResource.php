<?php

namespace App\Http\Resources\ManagerResources;

use App\Models\VotingResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $gifts    = $this->gifts()->withCount('voting_results')->orderByDesc('voting_results_count')->get();
        $voted    = VotingResult::where('vote_id', $this->id)->count();
        $nonVoted = $this->emails_sent - $voted;

        $gifts = $gifts->map(function ($item, $key) use ($voted) {

            return [
                'id' => $item->id,
                'title' => $item->title,
                'picture' => $item->picture,
                'link' => $item->link,
                'price' => $item->price,
                'votes' => $item->voting_results_count,
                'votesPercent' => round(100 * $item->voting_results_count / $voted, 2),
            ];
        });


        return [
            'end_at' => $this->end_at,
            'emails_sent' => $this->emails_sent,
            'voted' => $voted,
            'nonVoted' => $nonVoted,
            'gifts' => $gifts,

        ];
    }
}

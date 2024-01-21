<?php

namespace App\Http\Resources\ManagerResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteStatisticsResourceIndex extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'celebrant' => $this->celebrant->setVisible(['id', 'lastname', 'firstname']),
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'votes_count' => $this->votes_count,
            'gift' => $this->getTopVotedGifts($this->id),
        ];
    }
}

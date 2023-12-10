<?php

namespace App\Http\Resources\ManagerResources;

use App\Http\Resources\ManagerResources\GiftResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'celebrant_id' => $this->celebrant_id,
            'celebrant' => $this->celebrant->setVisible(['id', 'lastname', 'firstname', 'birthday']),
            'gift_id' => $this->gift_id,
            'gifts' => GiftResource::collection($this->gifts),
        ];
    }
}

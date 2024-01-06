<?php

namespace App\Http\Resources;

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
            'celebrant' => $this->celebrant->setVisible(['lastname', 'firstname', 'middlename', 'photo', 'birthday', 'position']),
            'hobbies' => $this->celebrant->hobbies->pluck('name'),
            'gifts' => GiftResource::collection($this->gifts),
        ];
    }
}

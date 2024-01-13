<?php

namespace App\Http\Resources\ManagerResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftResource extends JsonResource
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
            'title' => $this->title,
            'picture' => $this->picture,
            'link' => $this->link,
            'price' => $this->price,
            'votes' => $this->voting_results_count,
        ];
    }
}

<?php

namespace App\Http\Resources\ManagerResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GreetingCompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'celebrant_id' => $this->celebrant_id,
            'celebrant' => $this->celebrant()->select('id', 'lastname', 'firstname', 'birthday')->get(),
            'company' => $this->company()->select('id', 'name')->get(),
            'publish_at' => $this->publish_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

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
            'message_company' => $this->message_company,
            'celebrant_id' => $this->celebrant_id,
            'publish_at' => $this->publish_at,
        ];
    }
}

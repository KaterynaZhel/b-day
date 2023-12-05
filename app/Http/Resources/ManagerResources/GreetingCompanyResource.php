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
            'celebrant' => $this->celebrant->setVisible(['id', 'lastname', 'firstname', 'birthday']),
            'company' => $this->company->setVisible(['id', 'name']),
            'message_company' => $this->message_company,
            'publish_at' => $this->publish_at,
        ];
    }
}

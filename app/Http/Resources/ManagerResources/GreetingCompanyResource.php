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
        if (empty($this->lastname)) {
            $celebrant = $this->celebrant->setVisible(['id', 'lastname', 'firstname', 'birthday']);
        } else {
            $celebrant = [
                'lastname' => $this->lastname,
                'firstname' => $this->firstname,
                'birthday' => $this->birthday,
            ];
        }
        return [
            'id' => $this->id,
            'celebrant_id' => $this->celebrant_id,
            'celebrant' => $celebrant,
            'company' => $this->company->setVisible(['id', 'name']),
            'message_company' => $this->message_company,
            'publish_at' => $this->publish_at,

        ];
    }
}

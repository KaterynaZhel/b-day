<?php

namespace App\Http\Resources;

use App\Http\Resources\GreetingCompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CelebrantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'photo' => $this->photo,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'birthday' => $this->birthday,
            'email' => $this->email,
            'company' => new CompanyResource($this->company),
            'greetingsCompany' => GreetingCompanyResource::collection($this->greetingsCompany),
            'position' => $this->position,
            'hobbies' => $this->hobbies->pluck('name', 'id'),
            'gift_budget' => $this->gift_budget,
            'votes' => $this->votes->map(function ($vote) {
                return [
                    'start_at' => $vote->start_at,
                    'end_at' => $vote->end_at,
                ];
            }),
        ];
    }
}

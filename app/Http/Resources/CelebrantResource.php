<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

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
            'middlename' => $this->maidlename,
            'birthday' => $this->birthday,
            'position' => $this->position,

        ];
    }
}
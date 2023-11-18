<?php

namespace App\Http\Resources\ManagerResources;

use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'photo' => $this->photo,
            'lastname' => $this->lastname,
            'name' => $this->name,
            'middlename' => $this->middlename,
            'email' => $this->email,
            'company_name' => $this->company->name,
            'company_site' => $this->company->site,

        ];
    }
}

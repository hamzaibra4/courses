<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this['f_name'],
            'last_name'  => $this['l_name'],
            'email'  => $this->getUser?->email ?? "Unknown",
            'telephone'  => $this['telephone'],
            'dob'  => $this['dob'],
            'is_active'=>$this['is_active'],
        ];
    }
}

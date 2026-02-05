<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'courses' => MiniCourseResource::collection(
                $this->courses->map(fn ($c) => $c->getCourse)
            ),
            'company' => new CompanyResource($this->company)
        ];
    }
}

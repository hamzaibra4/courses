<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MiniCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this['id'],
            'name' => $this['name'],
            'price' => $this['price'],
            'description'  => $this['description'],
            'brief_description'  => $this['brief_description'],
            'nb_of_hours'  => $this['nb_of_hours'],
            'image'  => $this['image'],
            'item_index'  => $this['item_index'],
            'created_by'  => $this['created_by'],
            'currency'=> '$',
            'currency_name'=> 'USD',
            'details' => count($this->getDetails) > 0
                ?  CourseDetailsResource::collection($this->getDetails)
                : null,

            'number_of_lessons' => count($this->getChapters),
        ];
    }
}

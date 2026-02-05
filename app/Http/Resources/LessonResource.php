<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'title'=>$this['title'],
            'description'=>$this['description'],
            'item_index'=>$this['item_index'],
            'nb_of_hours'=>$this['nb_of_hours'],
            'video_path'=>asset($this['video_path']),
            'materials' => DocumentResource::collection(
                $this->getMaterials
                    ->flatMap(fn ($c) => $c->getMaterialPdfs)
            ),
        ];
    }
}

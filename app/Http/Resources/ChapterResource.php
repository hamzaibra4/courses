<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name'  =>$this['name'],
            'text' => $this['text'],
            'item_index' => $this['item_index'],
            'lessons' => LessonResource::collection($this->getSections),
            'materials' => DocumentResource::collection(
                $this->getMaterials
                    ->flatMap(fn ($c) => $c->getMaterialPdfs)
            ),
        ];
    }
}

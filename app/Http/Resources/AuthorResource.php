<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'authorId' => $this->id,
            'name' => $this->author_name,
        ];

        if ($this->relationLoaded('books')) {
            $data['books'] = BookWithRelationsIdsResource::collection($this->books);
        }

        if ($this->relationLoaded('publishers')) {
            $data['relatedPublishers'] = PublisherResource::collection($this->publishers);
        }

        return $data;
    }
}

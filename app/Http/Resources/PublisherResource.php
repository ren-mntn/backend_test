<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublisherResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'publisherId' => $this->id,
            'name' => $this->publisher_name,
        ];

        if ($this->relationLoaded('books')) {
            $data['books'] = BookWithRelationsIdsResource::collection($this->books);
        }

        if ($this->relationLoaded('authors')) {
            $data['relatedAuthors'] = AuthorResource::collection($this->authors);
        }

        return $data;
    }
}

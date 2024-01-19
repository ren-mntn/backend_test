<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookWithRelationsIdsResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'isbn' => $this->isbn,
            'name' => $this->book_name,
            'publishedAt' => $this->published_at,
            'authorId' => $this->author_id,
            'publisherId' => $this->publisher_id,
        ];
    }
}

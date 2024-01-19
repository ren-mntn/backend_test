<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'author' => new AuthorResource($this->author),
            'publisher' => new PublisherResource($this->publisher),
        ];
    }
}

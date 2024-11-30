<?php

namespace App\Http\Resources\BookCopy;

use Illuminate\Http\Resources\Json\JsonResource;

class BookCopyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'book_id' => $this->book_id,
            'book_title' => $this->book->title ?? null,
            'code' => $this->code,
            'status' => $this->status,
            'is_available' => $this->isAvailable(),
        ];
    }
}

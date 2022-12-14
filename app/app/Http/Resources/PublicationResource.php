<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'slug' => $this->slug,
            'description' => $this->description,
            'publication_year' => $this->publication_year,
            'publication_century' => $this->publication_century,
            'user' =>  new UserResource($this->user),
            'publishing_house' =>  new PublishingHouseResource($this->publishingHouse),
            // 'categories' => DocumentCategoryResource::collection($this->categories),
            'authors' => AuthorResource::collection($this->authors),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}

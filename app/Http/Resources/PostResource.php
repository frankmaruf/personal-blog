<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'tags' => $this->tags,
            'cover_image'=> $this->cover_image,
            'images'  => $this->getMedia('blog'),
            'body' => $this->body,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'categories_id' => $this->categories_id,
            "reads" => $this->reads,
            "premium" => $this->premium,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

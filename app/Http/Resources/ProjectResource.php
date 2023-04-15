<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        foreach ($this->users as $user) {
            $items[]   = (object) array($user->id, $user->name, $user->pivot->is_manager, $user->pivot->created_at->format('Y-m-d H:i:s A'), $user->pivot->updated_at->format('Y-m-d H:i:s A'));
        }
        return [
            "id" => $this->id,
            "name" => $this->name,
            "cover_photo" => $this->cover_photo,
            "sort_description" => $this->sort_description,
            "description" => $this->description,
            "live" => $this->live,
            "source_code" => $this->source_code,
            "users" => $items,
            "premium" => $this->premium,
            "status" => $this->status
        ];
    }
}

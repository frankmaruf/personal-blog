<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Permission;

class UserResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "picture" => $this->picture,
            "cv" => $this->cv,
            "bio" => $this->bio,
            "Role" => $this->getRoleNames(),
            "permission" => UserPermissionResource::collection($this->getAllPermissions()),
            // 'posts' => PostResource::collection($this->posts()),
        ];
    }
}

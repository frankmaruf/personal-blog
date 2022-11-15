<?php

namespace App\Http\Resources;

use DB;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class PermissionResource extends JsonResource
{
    public function toArray($request)
    {
        $all_roles_id_under_this_permission_id = array(
            DB::table('role_has_permissions')
            ->where("permission_id", $this->id)
            ->pluck('role_id')
        );
        foreach ($all_roles_id_under_this_permission_id as $role_id) {
            $role_name=  Role::findOrFail($role_id)->pluck("name");
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            "assigned_role" => $role_name,
        ];
    }
}

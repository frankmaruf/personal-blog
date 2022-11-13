<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','verified:api','role:super-admin'], ['except' => ['index,show']]);
    }
    public function index()
    {
        return RoleResource::collection(Role::all());
    }
    public function store(Request $request){
        $request->validate([
            "name" => "required|string|max:20"
        ]);
        $role = Role::create([
            'name'=>$request->name
        ]);
        return response()->json([
            "role" => $role,
            "Message" => "Role Created Successfully"
        ]);

    }
}

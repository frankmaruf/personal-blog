<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','verified:api','role:super-admin'], ['except' => ['index',"show"]]);
    }
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }
    public function store(Request $request, Permission $permission){
        $validate = $request->validate([
            "name" => "required|string|max:20"
        ]);
        $permission::create([
            $validate
        ]);
        return response()->json([
            "role" => new PermissionResource($permission),
            "Message" => "Permission Created Successfully"
        ]);

    }
    public function show($id){
        $permission = Permission::findOrFail($id);
        return new PermissionResource($permission);
    }
    public function update(Request $request, Permission $permission){
        $validated = $request->validate(["name"=>"required|string|max:20"]);
         $permission->update($validated);
         return response()->json([
            "permission" => new PermissionResource($permission),
            "Message" => "Permission Update Successfully"
         ]);
        
    }
    public function destroy(Permission $permission){
        $permission->findOfFail($permission)->destroy();
        return response()->json([
            "Message" => "Permission Delete Successfully"
        ]);
    }
}

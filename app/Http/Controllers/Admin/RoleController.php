<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','verified:api','role:super-admin'], ['except' => ['index',"show"]]);
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
    public function show($id){
        $role = Role::findOrFail($id);
        return response($role);
    }
    public function update(Request $request, $id){
        $validated = $request->validate(["name"=>"required|string|max:20"]);
        $role = Role::findOrFail($id);
         $role->update($validated);
         return response()->json([
            "role" => $role,
            "Message" => "Role Update Successfully"
         ]);
        
    }
    public function destroy($id){
        Role::findOfFail($id)->destroy();
        return response()->json([
            "Message" => "Role Delete Successfully"
        ]);
    }
}

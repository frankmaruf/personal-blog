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
    public function store(Request $request){
        $request->validate([
            "name" => "required|string|max:20"
        ]);
        $role = Permission::create([
            'name'=>$request->name
        ]);
        return response()->json([
            "role" => $role,
            "Message" => "Role Created Successfully"
        ]);

    }
}

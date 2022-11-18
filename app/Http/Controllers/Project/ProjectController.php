<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => ['index,show']]);
    }
    public function index()
    {
        $projects = Project::paginate(15);
        return response($projects);
    }
    public function store(Request $request)
    {
        $project = Project::create([
            'name' => $request->name,
            'cover_photo' => $request->cover_photo,
            'sort_description' => $request->sort_description,
            'description' => $request->description,
            'live' => $request->live,
            'source_code' => $request->source_code,
            'users_id' => auth()->user()->id,
        ]);
        return response()->json([
            "project" => $project,
            "message" => "Project Created Successfully"
        ]);
    }
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json([
            $project,
        ]);
    }
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $data = $request->only([
            ""
        ]);
        $updateProject = $project->update($data);
        return response()->json([
            "project" => $updateProject,
            "message" => "update Successfully"
        ]);
    }
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        return response()->json([
            "message" => "Deleted Successfully"
        ]);
    }
}

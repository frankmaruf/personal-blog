<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Auth;
use DB;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Blog::class);
        $this->middleware(['auth:api'], ['except' => ["show","index"]]);
    }
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasAnyRole(["super-admin", "admin"])) {
                $projects = Project::with("users")->orderBy('id', 'DESC')->paginate(15);
                return ProjectResource::collection($projects);
            }
        }
        $projects = Project::status()->with("users")->orderBy('id', 'DESC')->paginate(15);
        return ProjectResource::collection($projects);
    }
    public function managers()
    {

        $projects = Project::whereHas('users', function ($query) {
            return $query->where('is_manager', '=', 1);
        })->paginate(15);
        return ProjectResource::collection($projects);
    }
    public function store(Request $request, Project $project)
    {
        $this->authorize("create", $project);
        $project = $project::create([
            'name' => $request->name,
            'cover_photo' => $request->cover_photo,
            'sort_description' => $request->sort_description,
            'description' => $request->description,
            'live' => $request->live,
            'source_code' => $request->source_code,
        ]);
        $project->users()->attach(Auth::user(), ['is_manager' => 1]);
        if ($users = $request->input("users")) {
            $project->users()->attach($users);
        }
        return response()->json([
            "project" => $project,
            "message" => "Project Created Successfully"
        ]);
    }
    public function show($id)
    {
        $project = Project::findOrFail($id);
        $this->authorize("view", $project);
        return new ProjectResource($project);
    }
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->authorize("update", $project);
        
        $data= $request->only([
            'name',
            'cover_photo',
            'sort_description',
            'description',
            'live',
            'source_code',
            "status",
        ]);
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasAnyRole(["super-admin", "admin"])) {
              $request->input('premium');
            }
        }
        $updateProject = $project->update($data);
        if ($users = $request->input("users")) {
            $project->users()->attach($users);
        }
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

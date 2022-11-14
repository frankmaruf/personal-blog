<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Auth;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Blog::class);
        $this->middleware(['auth:api'], ['except' => ["show"]]);
    }
    public function index()
    {
        $this->authorize("viewAny", Blog::class);
        $blog = Blog::status()->paginate(15);
        return response()->json([
            $blog
        ]);
    }
    public function store(Request $request)
    {
        $this->authorize("create", Blog::class);
        $post = Blog::create([
            "title" => $request->title,
            "slug" => $request->slug,
            "meta_description" => $request->meta_description,
            "meta_keywords" => $request->meta_keywords,
            "tags" => $request->tags,
            "cover_image" => $request->cover_image,
            "body" => $request->body,
            "user_id" => auth()->user()->id,
            "category_id" => $request->category_id,
        ]);
        return response($post);
    }
    public function show($id)
    {
        $post = Blog::findOrFail($id);
        $this->authorize("view", $post);
        return response($post);
    }
    public function showBySlug($slug)
    {
        $post = Blog::whereSlug($slug);
        $this->authorize("view", $post);
        return response($post);
    }
    public function update(Request $request, $id)
    {
        $post = Blog::findOrFail($id);
        $this->authorize("update", $post);
        $data = $request->only([
            'title',
            'slug',
            "meta_description",
            "meta_keywords",
            "tags",
            "cover_image",
            "body",
            "user_id",
            "category_id",
            "status",
        ]);
        $updateData = $post->update($data);
        return response()->json($updateData);
    }
    public function destroy($id)
    {
        $post = Blog::findOrFail($id);
        $this->authorize("delete", $post);
        $post->delete();
        return response()->json('Deleted Successfully');
    }
}

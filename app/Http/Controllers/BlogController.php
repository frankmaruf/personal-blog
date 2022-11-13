<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','verified:api'], ['except' => ['index,show,showBySlug']]);
    }
    public function index()
    {
        $posts = Blog::paginate(15);
        return response()->json([
            $posts
        ]);
    }
    public function store(Request $request)
    {
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
        $post = Blog::find($id);
        return response($post);
    }
    public function showBySlug($slug)
    {
        $post = Blog::find($slug);
        return response($post);
    }
    public function update(Request $request, $id)
    {
        $post = Blog::findOrFail($id);
        $data = $request->only([
            'title',
            'slug',
            "meta_description",
            "meta_keywords",
            "tags",
            "cover_image",
            "body",
            "user_id",
            "category_id"
        ]);
        $updateData = $post->update($data);
        return response()->json($updateData);
    }
    public function destroy($id)
    {
        Blog::findOrFail($id)->delete();
        return response()->json('Deleted Successfully');
    }
}

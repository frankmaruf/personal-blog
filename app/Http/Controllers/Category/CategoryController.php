<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','verified:api'], ['except' => ['index','show','categoryPost']]);
    }
    public function index()
    {
        $categories = Category::paginate(15);
        return response()->json([
            $categories
        ]);
    }
    public function categoryPost($id){
        $categories = Category::findOrFail($id);
        $posts = $categories->posts;
        return PostResource::collection($posts);
    }
    public function show($id){
        $category = Category::findOrFail($id);
        return response($category);
    }
    public function store(Request $request){
        $category = Category::create([
            "title" => $request->title,
            "slug" => $request->slug,
            "body" => $request->body,
            "meta_description"=> $request->meta_description,
            "meta_keywords" => $request->meta_keywords,
            "cover_image"=> $request->cover_image,
            "parent_id" => $request,
        ]);
        return response()->json([
            "category" => $category,
            "Message" => "Category Create Successfully"
        ]);
    }
    public function update($id, Request $request){
        $category = Category::findOrFail($id);
        $data = $request->only([
            'title',
            'slug',
            "body",
            "meta_description",
            "meta_keywords",
            "cover_image",
            "parent_id",
            "status",
        ]);
      $updateCategory =   $category->update(
            $data
    );
    return response()->json([
        "category" => $category,
        "Message" => "Category Update Successfully"
    ]);
    }
    public function destroy($id){
        Category::findOrFail($id)->delete();
        return response()->json('Deleted Successfully');
    }
}

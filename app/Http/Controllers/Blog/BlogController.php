<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\PostResource;
use App\Models\Blog;
use Auth;
use Cookie;
use Illuminate\Http\Request;
use Str;
use Validator;

class BlogController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Blog::class);
        $this->middleware(['auth:api'], ['except' => ["index", "show", "latestPost", "showBySlug"]]);
    }
    public function index(Blog $blog)
    {
        $this->authorize("viewAny", $blog);
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasAnyRole(["super-admin", "admin"])) {
                $post = Blog::orderBy('id', 'DESC')->paginate(15);
                return PostResource::collection($post);
            }
        }
        $post = Blog::status()->orderBy('id', 'DESC')->paginate(15);
        return PostResource::collection($post);
    }
    public function authUserPost()
    {
        $posts = Auth::user()->posts()->orderBy('id', 'DESC')->paginate(15);
        return PostResource::collection($posts);
    }

    public function latestPost()
    {
        $this->authorize("viewAny", Blog::class);
        $post = Blog::status()->orderBy('id', 'DESC')->skip(0)->take(5)->get();
        return PostResource::collection($post);
    }
    public function topPost()
    {
        $this->authorize("viewAny", Blog::class);
        $post = Blog::orderBy('count', 'DESC')->skip(0)->take(10)->get();;
        return PostResource::collection($post);
    }
    public function store(BlogRequest $request, Blog $blog)
    {
        // $blog = Auth::user()->blogs()->create(request([
        // ]));
        $this->authorize("create", $blog);
        $post = $blog::create([
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
        if ($request->hasFile('photo')) {
            $post->addMultipleMediaFromRequest(['photo'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('blog');
                });
        }
        // ### Way 3:::
        ##### in HTML
        // <input type="file" name="photo[]" multiple />
        return new PostResource($post);
    }
    public function show($id, Request $request)
    {
        $post = Blog::findOrFail($id);
        $this->authorize("view", $post);
        if (!Auth::check()) { //guest user identified by ip
            $cookie_name = (Str::replace('.', '', ($request->ip())) . '-' . $post->id);
        } else {
            $cookie_name = (Auth::user()->id . '-' . $post->id); //logged in user
        }
        if (Cookie::get($cookie_name) == '') { //check if cookie is set
            $cookie = cookie($cookie_name, '1', 60 * 24 * 365); //set the cookie
            $post->incrementReadCount(); //count the view
            return response($post)
                ->withCookie($cookie); //store the cookie
        } else {
            return new PostResource($post); //this view is not counted
        }
    }
    public function showBySlug($slug)
    {
        $post = Blog::whereSlug($slug);
        $this->authorize("view", $post);
        $post->incrementReadCount();
        return response($post);
    }
    public function update(BlogRequest $request, $id)
    {
        $post = Blog::findOrFail($id);
        $this->authorize("update", $post);
        if ($request->hasFile('photo')) {
            $post->addMultipleMediaFromRequest(['photo'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('blog');
                });
        }
        $post->update($request->validated());
        return response()->json([
            "Blog" => $post,
            "message" => "Update Successfully"
        ]);
    }
    public function destroy($id)
    {
        $post = Blog::findOrFail($id);
        $this->authorize("delete", $post);
        $post->delete();
        return response()->json('Deleted Successfully');
    }
}

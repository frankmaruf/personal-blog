<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Blog;
use Auth;
use Cookie;
use Illuminate\Http\Request;
use Str;

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
            };
        }
        $post = Blog::status()->orderBy('id', 'DESC')->paginate(15);
        return PostResource::collection($post);
    }
    public function authUserPost()
    {
        // if (Auth::check()) {
            $id = Auth::user()->getId();
        // }
        $posts = Blog::where("user_id", $id)->orderBy('id', 'DESC')->paginate(15);
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
        return new PostResource($post);
    }
    // public function show($id)
    // {
    //     $post = Blog::findOrFail($id);
    //     $this->authorize("view", $post);
    //     $posts_id = array();
    //     $posts_id[] = $post->id;
    //     $cookie_name = ("posts_id");
    //     if (Cookie::get($cookie_name) == '') {
    //         $cookie = cookie($cookie_name, serialize($posts_id), 60 * 24 * 365); //set the cookie
    //         $post->incrementReadCount(); //count the view
    //         return response($post)
    //             ->withCookie($cookie); //store the cookie
    //     } else {
    //         $cookie = Cookie::get($cookie_name);
    //         $oldCookie = unserialize($cookie);
    //         $alert = false;
    //         $cookieLen = count($oldCookie);
    //         $i = 0;
    //         while ($i <= $cookieLen && !$alert) {
    //             if ($oldCookie[$i] === $post->id) {
    //                 $alert = true;
    //                 $i++;
    //             } else {
    //                 $alert = false;
    //                 $i++;
    //             }
    //         }
    //         if ($alert) {
    //             return response($post);
    //         } else {
    //             $oldCookie[] = $post->id;
    //              var_dump($oldCookie);
    //             $cookie = cookie($cookie_name, serialize(array($oldCookie)), 60 * 24 * 365); //set the cookie
    //             $post->incrementReadCount();
    //             return response($post)->withCookie($cookie);
    //         }
    //     }

    //     return  response($post); //this view is not counted
    // }
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
            return  response($post); //this view is not counted
        }
    }
    public function showBySlug($slug)
    {
        $post = Blog::whereSlug($slug);
        $this->authorize("view", $post);
        $post->incrementReadCount();
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

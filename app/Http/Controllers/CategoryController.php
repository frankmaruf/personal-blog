<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','verified:api'], ['except' => ['index,show']]);
    }
    public function index()
    {
        $categories = Category::paginate(15);
        return response()->json([
            $categories
        ]);
    }
}

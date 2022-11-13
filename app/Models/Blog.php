<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blog extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $fillable = [
        "title",
        "slug",
        "meta_description",
        "meta_keywords",
        "tags",
        "cover_image",
        "body",
        "user_id",
        "categories_id",
    ];
//    public function user(): HasOne
//    {
//        return $this->hasOne(User::class);
//    }
//    public function category(): HasOne
//    {
//        return $this->hasOne(Category::class, "category_id");
//    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}

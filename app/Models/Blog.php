<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
/**
 * App\Models\Blog
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $tags
 * @property string $cover_image
 * @property string $body
 * @property int|null $user_id
 * @property int|null $categories_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\BlogFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCategoriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUserId($value)
 * @mixin \Eloquent
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereStatus($value)
 */
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
    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
    public function scopeStatus(Builder $query)
    {
        return $query->where('status', 1);
    }
}

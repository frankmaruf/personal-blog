<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $fillable = [
        "title",
        "slug",
        "meta_description",
        "meta_keywords",
        "cover_image",
        "parent_id",
    ];
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }
    public function parent_category(): HasMany
    {
        return $this->hasMany(Category::class);
    }
    public function child_category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}
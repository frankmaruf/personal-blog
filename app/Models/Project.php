<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $fillable = [
        'name',
        'sample_photo',
        'sort_description',
        "description",
        "live",
        "source_code",
        "users_id"
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

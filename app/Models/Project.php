<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property string $name
 * @property string $cover_photo
 * @property string $sort_description
 * @property string $description
 * @property string $live
 * @property string $source_code
 * @property int|null $users_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ProjectFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCoverPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereSortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereSourceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUsersId($value)
 * @mixin \Eloquent
 */
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
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
        "status",
        "premium"
    ];
    protected $attributes = [
        'status' => true,
        'premium' => false,
    ];
    // public function users() : BelongsToMany
    // {
    //     return $this->belongsToMany(User::class);
    // }

    // public function users() : BelongsToMany
    // {
    //     return $this->belongsToMany(User::class)->withTimestamps()->using(ProjectUser::class)->withPivot(["is_manager"]);
    // }
    // public function managers()
    // {
    //     return $this->belongsToMany(User::class)->withPivot(["is_manager"])->wherePivot("is_manager","=",1)->withTimestamps();;
    // }
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_manager')
            ->withTimestamps();
    }

    public function scopeStatus(Builder $query)
    {
        return $query->where('status', 1);
    }
    // public function managers()
    // {
    //     return $this->users()->wherePivot('is_manager',"=" ,1);
    // }
}

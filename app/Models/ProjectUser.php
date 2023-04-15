<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectUser extends Pivot
{
    protected $table = "project_user";
    // public function users(): BelongsToMany
    // {
    //     return $this->BelongsToMany(User::class);
    // }
    // public function managers() : BelongsToMany
    // {
    //     return $this->belongsToMany(User::class);
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

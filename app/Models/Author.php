<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
        'name',
        'username',
        'email_address',
        'profile_picture',
        'social_media',
        'bio',
    ];

    public function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Banner extends Model
{
    protected $fillable = [
        'post_id',
    ];

    public function post(): HasOne
    {
        return $this->hasOne(Post::class);
    }
}

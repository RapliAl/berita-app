<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Post extends Model
{
    protected $fillable = [
        'author_id',
        'categories_id',
        'title',
        'slug',
        'content',
        'image_content',
        'published_date',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }
}

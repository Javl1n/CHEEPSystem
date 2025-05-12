<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['file'];

    /**
     * Get the user that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the post's image.
     */
    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }
}

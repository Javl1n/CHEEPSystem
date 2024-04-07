<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the parent fileable model (user verification, post, comment or message).
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}

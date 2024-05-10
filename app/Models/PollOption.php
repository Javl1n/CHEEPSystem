<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PollOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the title that owns the PollOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function title(): BelongsTo
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

    /**
     * Get all of the votes for the PollOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes(): HasMany
    {
        return $this->hasMany(PollVote::class, 'option_id');
    }
}

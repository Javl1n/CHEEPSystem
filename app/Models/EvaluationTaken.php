<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvaluationTaken extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the teacher that owns the EvaluationTaken
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the student that owns the EvaluationTaken
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get all of the scores for the EvaluationTaken
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scores(): HasMany
    {
        return $this->hasMany(EvaluationScore::class, 'evaluation_id');
    }

    /**
     * Get the subject that owns the EvaluationTaken
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}

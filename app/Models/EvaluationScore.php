<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationScore extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the question that owns the EvaluationScore
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(EvaluationQuestion::class, 'question_id');
    }

    /**
     * Get the evaluation that owns the EvaluationScore
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(EvaluationTaken::class, 'evaluation_id');
    }
}

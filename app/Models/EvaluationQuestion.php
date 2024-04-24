<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the scores for the EvaluationQuestion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scores(): HasMany
    {
        return $this->hasMany(EvaluationScore::class, 'question_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = []; 

    /**
     * Get all of the evaluations for the Subject
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(EvaluationTaken::class);
    }
}

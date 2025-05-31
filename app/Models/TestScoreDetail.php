<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestScoreDetail extends Model
{
    protected $fillable = [
        'test_score_id',
        'course_id',
        'score',
    ];

    public function testScore(): BelongsTo
    {
        return $this->belongsTo(TestScore::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // TODO Scope
    #[Scope]
    protected function filterData(Builder $query, $filter): Builder
    {
        return $query->where([
            'test_score_id' => $filter['test_score_id'],
            'course_id' => $filter['course_id']
        ]);
    }
}

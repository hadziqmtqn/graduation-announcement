<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestScoreDetail extends Model
{
    protected $fillable = [
        'test_score_id',
        'course_id',
        'score',
    ];
}

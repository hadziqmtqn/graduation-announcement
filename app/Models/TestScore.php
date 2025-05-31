<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestScore extends Model
{
    protected $fillable = [
        'slug',
        'school_year_id',
        'student_id',
        'rank',
        'avg_score',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string',
        ];
    }
}

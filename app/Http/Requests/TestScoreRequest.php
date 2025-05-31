<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestScoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'school_year_id' => ['required', 'integer'],
            'student_id' => ['required', 'integer'],
            'rank' => ['nullable', 'integer'],
            'avg_score' => ['required', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

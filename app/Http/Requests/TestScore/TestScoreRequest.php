<?php

namespace App\Http\Requests\TestScore;

use Illuminate\Foundation\Http\FormRequest;

class TestScoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'array'],
            'student_id.*' => ['required', 'integer', 'exists:students,id'],
            'course_id' => ['required', 'array'],
            'course_id.*' => ['required', 'integer', 'exists:courses,id'],
            'score' => ['required', 'array'],
            'score.*' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'student_id' => 'siswa',
            'student_id.*' => 'siswa',
            'course_id' => 'mata pelajaran',
            'course_id.*' => 'mata pelajaran',
            'score' => 'nilai',
            'score.*' => 'nilai'
        ];
    }
}

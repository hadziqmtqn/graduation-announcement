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
            'score' => ['required', 'array'],
            'score.*' => ['array'], // tiap siswa harus array skor
            'score.*.*' => ['nullable', 'numeric'], // nilai skor bisa null atau angka
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
            'score' => 'nilai',
            'score.*' => 'nilai',
            'score.*.*' => 'nilai'
        ];
    }
}

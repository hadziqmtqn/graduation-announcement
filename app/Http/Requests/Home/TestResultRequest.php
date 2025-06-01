<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class TestResultRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'exam_number' => ['required', 'exists:students,exam_number']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'exam_number' => 'nomor ujian'
        ];
    }
}

<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => ['required'],
            'exam_number' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'full_name' => 'nama lengkap',
            'exam_number' => 'nomor ujian'
        ];
    }
}

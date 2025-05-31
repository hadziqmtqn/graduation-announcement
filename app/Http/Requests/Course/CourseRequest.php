<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'unique:courses,code'],
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'code' => 'kode',
            'name' => 'nama'
        ];
    }
}

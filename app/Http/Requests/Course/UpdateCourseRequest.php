<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'unique:courses,code,' . $this->route('course')->slug . ',slug'],
            'name' => ['required'],
            'is_active' => ['required', 'boolean']
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
            'name' => 'nama',
            'is_active' => 'status aktif'
        ];
    }
}

<?php

namespace App\Http\Requests\SchoolYear;

use Illuminate\Foundation\Http\FormRequest;

class SchoolYearRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_year' => ['required', 'date_format:Y', 'before:last_year'],
            'last_year' => ['required', 'date_format:Y', 'after:first_year'],
            'announcement_start_date' => ['required', 'date', 'before:announcement_end_date'],
            'announcement_end_date' => ['required', 'date', 'after:announcement_start_date'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'first_year.before' => ':attribute harus sebelum tahun akhir',
            'last_year.after' => ':attribute harus setelah tahun awal'
        ];
    }

    public function attributes(): array
    {
        return [
            'first_year' => 'tahun awal',
            'last_year' => 'tahun akhir',
            'announcement_start_date' => 'tanggal mulai pengumuman',
            'announcement_end_date' => 'tanggal akhir pengumuman',
            'is_active' => 'status aktif'
        ];
    }
}

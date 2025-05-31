<?php

namespace App\Imports;

use App\Jobs\StudentImportJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class StudentImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection): void
    {
        foreach ($collection as $row) {
            StudentImportJob::dispatch($row);
        }
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            '*.nama_lengkap' => ['required', 'string'],
            '*.nomor_ujian' => ['required', 'string', 'unique:students,exam_number']
        ];
    }
}

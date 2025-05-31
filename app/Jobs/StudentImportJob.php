<?php

namespace App\Jobs;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StudentImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected mixed $row;

    public function __construct(mixed $row)
    {
        $this->row = $row;
    }

    public function handle(): void
    {
        $student = new Student();
        $student->full_name = $this->row['nama_lengkap'];
        $student->exam_number = $this->row['nomor_ujian'];
        $student->save();
    }
}

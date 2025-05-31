<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class CourseSeeder extends Seeder
{
    /**
     * @throws InvalidArgument
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/mapel.csv'))
            ->setDelimiter(';')
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $course = new Course();
            $course->code = $row['code'];
            $course->name = $row['name'];
            $course->save();
        }
    }
}

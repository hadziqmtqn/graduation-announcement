<?php

namespace Database\Seeders;

use App\Models\SchoolYear;
use Illuminate\Database\Seeder;

class SchoolYearSeeder extends Seeder
{
    public function run(): void
    {
        $schoolYear = new SchoolYear();
        $schoolYear->first_year = 2024;
        $schoolYear->last_year = 2025;
        $schoolYear->announcement_start_date = '2025-06-01 07:00:00';
        $schoolYear->announcement_end_date = '2025-07-01 07:00:00';
        $schoolYear->save();
    }
}

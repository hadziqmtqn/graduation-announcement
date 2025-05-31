<?php

namespace App\Services;

use App\Models\SchoolYear;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SchoolYearService
{
    protected SchoolYear $schoolYear;

    /**
     * @param SchoolYear $schoolYear
     */
    public function __construct(SchoolYear $schoolYear)
    {
        $this->schoolYear = $schoolYear;
    }

    public function getData(): Collection
    {
        $schoolYear = $this->schoolYear->active()
            ->first();

        return collect([
            'year' => $schoolYear ? $schoolYear->year : null,
            'announcementStartDate' => $schoolYear ? Carbon::parse($schoolYear->announcement_start_date)->isoFormat('DD MMM Y') : null,
            'announcementEndDate' => $schoolYear ? Carbon::parse($schoolYear->announcement_end_date)->isoFormat('DD MMM Y') : null,
        ]);
    }
}

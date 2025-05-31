<?php

namespace App\Services;

use App\Models\SchoolYear;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SchoolYearService
{
    use ApiResponse;

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
            'id' => $schoolYear?->id,
            'slug' => $schoolYear?->slug,
            'year' => $schoolYear ? $schoolYear->year : null,
            'announcementStartDate' => $schoolYear ? Carbon::parse($schoolYear->announcement_start_date)->isoFormat('DD MMM Y') : null,
            'announcementEndDate' => $schoolYear ? Carbon::parse($schoolYear->announcement_end_date)->isoFormat('DD MMM Y') : null,
        ]);
    }

    public function select($request): JsonResponse
    {
        try {
            $schoolYears = $this->schoolYear
                ->search($request)
                ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $schoolYears->map(function (SchoolYear $schoolYear) {
            return [
                'id' => $schoolYear->id,
                'year' => $schoolYear->year
            ];
        }), null, Response::HTTP_OK);
    }

    public function all(): Collection
    {
        return $this->schoolYear->get();
    }
}

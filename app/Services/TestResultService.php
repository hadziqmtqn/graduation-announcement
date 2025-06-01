<?php

namespace App\Services;

use App\Http\Requests\Home\TestResultRequest;
use App\Models\Student;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TestResultService
{
    use ApiResponse;

    public function __construct()
    {
    }

    public function testResult(TestResultRequest $request): JsonResponse
    {
        try {
            $student = Student::with('testScore')
                ->whereHas('testScore')
                ->filterByExamNumber($request->input('exam_number'))
                ->first();

            if (!$student) return $this->apiResponse('Data siswa tidak ditemukan');

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal ditampilkan', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil ditampilkan', [
            'examNumber' => $student->exam_number,
            'fullName' => $student->full_name,
            'avgScore' => number_format($student->testScore?->avg_score,2)
        ], null, Response::HTTP_OK);
    }
}

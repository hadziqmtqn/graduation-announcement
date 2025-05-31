<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestScore\TestScoreRequest;
use App\Jobs\TestScore\CreateTestScoreJob;
use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\TestScore;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TestScoreController extends Controller
{
    public function index(): View
    {
        $title = 'Nilai Ujian';

        return \view('dashboard.test-score.index', compact('title'));
    }

    public function create(SchoolYear $schoolYear): View
    {
        $title = 'Tambah Nilai Ujian';
        $schoolYear->load('students');
        $courses = Course::with([
            'testScoreDetails' => function ($query) use ($schoolYear) {
                $query->whereHas('testScore', function ($query) use ($schoolYear) {
                    $query->schoolYearId($schoolYear->id)
                        ->whereIn('student_id', $schoolYear->students->pluck('id')->toArray());
                });
            }
        ])
            ->get();

        return \view('dashboard.test-score.create', compact('title', 'schoolYear', 'courses'));
    }

    public function store(TestScoreRequest $request, SchoolYear $schoolYear): RedirectResponse
    {
        try {
            $students = Student::whereIn('id', $request->input('student_id', []))
                ->get();

            foreach ($students as $student) {
                CreateTestScoreJob::dispatch($schoolYear, $student, $request->input('course_id', []), $request->input('score', []));
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function show(TestScore $testScore)
    {
        return $testScore;
    }

    public function update(TestScoreRequest $request, TestScore $testScore)
    {
        $testScore->update($request->validated());

        return $testScore;
    }

    public function destroy(TestScore $testScore)
    {
        $testScore->delete();

        return response()->json();
    }
}

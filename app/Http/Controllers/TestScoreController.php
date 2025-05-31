<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestScore\TestScoreRequest;
use App\Jobs\TestScore\CreateTestScoreJob;
use App\Jobs\TestScore\UpdateTestScoreRankJob;
use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\TestScoreDetail;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TestScoreController extends Controller
{
    public function index(SchoolYear $schoolYear): View
    {
        $title = 'Nilai Ujian';

        // Ambil semua siswa
        $schoolYear->load([
            'students' => fn($query) => $query->orderBy('exam_number'),
            'students.testScore'
        ]);

        $students = $schoolYear->students;

        // Ambil semua course
        $courses = Course::active()
            ->get();

        // Ambil semua testScoreDetail yang cocok untuk tahun ajaran ini
        $testScoreDetails = TestScoreDetail::with(['course', 'testScore'])
            ->whereHas('testScore', function ($query) use ($schoolYear) {
                $query->schoolYearId($schoolYear->id);
            })
            ->get();

        // Kelompokkan detail berdasarkan student_id dan course_id
        $detailMap = $testScoreDetails->mapWithKeys(function ($detail) {
            $studentId = $detail->testScore->student_id;
            $courseId = $detail->course_id;
            return ["$studentId:$courseId" => $detail->score];
        });

        // Siapkan testScores per student
        $testScores = $students->map(function (Student $student) use ($courses, $detailMap) {
            return collect([
                'studentId' => $student->id,
                'examNumber' => $student->exam_number,
                'fullName' => $student->full_name,
                'totalScore' => number_format($student->testScore?->total_score, 2, '.', ''),
                'avgScore' => number_format($student->testScore?->avg_score, 2),
                'rank' => $student->testScore?->rank,
                'scores' => $courses->map(function (Course $course) use ($student, $detailMap) {
                    $key = "$student->id:$course->id";
                    return [
                        'id' => $course->id,
                        'name' => $course->name,
                        'score' => $detailMap[$key] ?? null,
                    ];
                })
            ]);
        });

        return view('dashboard.test-score.index', compact('title', 'schoolYear', 'courses', 'testScores'));
    }

    public function store(TestScoreRequest $request, SchoolYear $schoolYear): RedirectResponse
    {
        try {
            $scores = $request->input('score', []); // ['student_id' => ['course_id' => score]]
            foreach ($scores as $studentId => $scorePerCourse) {
                $student = Student::findOrFail($studentId);

                foreach ($scorePerCourse as $courseId => $score) {
                    CreateTestScoreJob::dispatch($schoolYear, $student, $courseId, $score);
                }
            }

            UpdateTestScoreRankJob::dispatch($schoolYear->id);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestScore\TestScoreRequest;
use App\Jobs\TestScore\CreateTestScoreJob;
use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\TestScore;
use App\Models\TestScoreDetail;
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

        // Ambil semua siswa
        $schoolYear->load([
            'students' => fn($query) => $query->orderBy('exam_number')
        ]);

        $students = $schoolYear->students;

        // Ambil semua course
        $courses = Course::all();

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

        return view('dashboard.test-score.create', compact('title', 'schoolYear', 'courses', 'testScores'));
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

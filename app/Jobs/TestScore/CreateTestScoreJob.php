<?php

namespace App\Jobs\TestScore;

use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\TestScore;
use App\Models\TestScoreDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CreateTestScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected SchoolYear $schoolYear;
    protected Student $student;
    protected int $courseId;
    protected mixed $score;

    public function __construct(SchoolYear $schoolYear, Student $student, int $courseId, mixed $score)
    {
        $this->schoolYear = $schoolYear;
        $this->student = $student;
        $this->courseId = $courseId;
        $this->score = $score;
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $testScore = TestScore::filterData([
                'school_year_id' => $this->schoolYear->id,
                'student_id' => $this->student->id
            ])
                ->lockForUpdate()
                ->firstOrNew();

            $testScore->school_year_id = $this->schoolYear->id;
            $testScore->student_id = $this->student->id;
            $testScore->avg_score = 0;
            $testScore->save();

            $testScoreDetail = TestScoreDetail::filterData([
                'test_score_id' => $testScore->id,
                'course_id' => $this->courseId
            ])
                ->lockForUpdate()
                ->firstOrNew();

            $testScoreDetail->test_score_id = $testScore->id;
            $testScoreDetail->course_id = $this->courseId;
            $testScoreDetail->score = $this->score;
            $testScoreDetail->save();

            $testScore->avg_score = $testScore->testScoreDetails()->avg('score');
            $testScore->save();
            DB::commit();
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());
            DB::rollBack();
        }
    }
}
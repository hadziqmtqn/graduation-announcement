<?php

namespace App\Services;

use App\Models\TestScore;
use Illuminate\Support\Facades\DB;
use Throwable;

class TestScoreRankService
{
    public function __construct()
    {
    }

    /**
     * @throws Throwable
     */
    public static function updateRank(int $schoolYearId): void
    {
        DB::transaction(function () use ($schoolYearId) {
            $testScores = TestScore::where('school_year_id', $schoolYearId)
                ->orderByDesc('avg_score')
                ->orderBy('student_id') // optional tie-breaker
                ->get();

            /*$rank = 1;
            $prevScore = null;
            $sameRankCount = 1;

            foreach ($testScores as $index => $testScore) {
                if ($testScore->avg_score === $prevScore) {
                    // Nilai sama → peringkat tetap
                    $testScore->rank = $rank;
                    $sameRankCount++;
                } else {
                    // Nilai berbeda → peringkat naik
                    $rank = $index + 1;
                    $testScore->rank = $rank;
                    $sameRankCount = 1;
                }

                $testScore->save();
                $prevScore = $testScore->avg_score;
            }*/
            foreach ($testScores as $index => $testScore) {
                $testScore->rank = $index + 1; // Urutan berdasarkan posisi
                $testScore->save();
            }
        });
    }
}

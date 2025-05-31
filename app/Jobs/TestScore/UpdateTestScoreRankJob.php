<?php

namespace App\Jobs\TestScore;

use App\Services\TestScoreRankService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class UpdateTestScoreRankJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $schoolYearId;

    public function __construct(int $schoolYearId)
    {
        $this->schoolYearId = $schoolYearId;
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        TestScoreRankService::updateRank($this->schoolYearId);
    }
}

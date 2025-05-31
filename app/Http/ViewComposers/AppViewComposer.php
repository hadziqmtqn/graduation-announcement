<?php

namespace App\Http\ViewComposers;

use App\Services\SchoolYearService;
use Illuminate\View\View;

class AppViewComposer
{
    protected SchoolYearService $schoolYearService;

    /**
     * @param SchoolYearService $schoolYearService
     */
    public function __construct(SchoolYearService $schoolYearService)
    {
        $this->schoolYearService = $schoolYearService;
    }

    public function compose(View $view): void
    {
        $view->with('schoolYearActive', $this->schoolYearService->getData());
    }
}

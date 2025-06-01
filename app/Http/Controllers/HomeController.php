<?php

namespace App\Http\Controllers;

use App\Http\Requests\Home\TestResultRequest;
use App\Services\TestResultService;

class HomeController extends Controller
{
    protected TestResultService $testResultService;

    /**
     * @param TestResultService $testResultService
     */
    public function __construct(TestResultService $testResultService)
    {
        $this->testResultService = $testResultService;
    }

    public function index()
    {
        return view('home');
    }

    public function testResult(TestResultRequest $request)
    {
        return $this->testResultService->testResult($request);
    }
}

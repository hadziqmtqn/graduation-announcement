<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestScore\TestScoreRequest;
use App\Models\TestScore;

class TestScoreController extends Controller
{
    public function index()
    {
        return TestScore::all();
    }

    public function store(TestScoreRequest $request)
    {
        return TestScore::create($request->validated());
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

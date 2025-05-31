<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        return Course::all();
    }

    public function store(CourseRequest $request)
    {
        return Course::create($request->validated());
    }

    public function show(Course $course)
    {
        return $course;
    }

    public function update(CourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return $course;
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json();
    }
}

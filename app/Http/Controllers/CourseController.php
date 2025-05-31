<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    use ApiResponse;

    public function index(): View
    {
        $title = 'Mata Pelajaran';

        return \view('dashboard.course.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Course::query()
                    ->withCount('testScoreDetails')
                    ->orderByDesc('created_at');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['code', 'name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('is_active', function ($row) {
                        $status = match ($row->is_active) {
                            true => ['badge' => 'bg-primary', 'label' => 'Aktif'],
                            false => ['badge' => 'bg-danger', 'label' => 'Tidak aktif'],
                            default => ['badge' => 'bg-secondary', 'label' => 'Tidak ada status']
                        };

                        return '<span class="badge rounded-pill '. $status['badge'] .'">'. $status['label'] .'</span>';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<button type="button" data-slug="'. $row->slug .'" data-name="'. $row->name .'" data-code="'. $row->code .'" data-active="'. $row->is_active .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        if ($row->test_score_details_count == 0) {
                            $btn .= '<button type="button" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action', 'is_active'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(CourseRequest $request): RedirectResponse
    {
        try {
            $course = new Course();
            $course->code = $request->input('code');
            $course->name = $request->input('name');
            $course->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function update(UpdateCourseRequest $request, Course $course): JsonResponse
    {
        try {
            $course->code = $request->input('code');
            $course->name = $request->input('name');
            $course->is_active = $request->input('is_active');
            $course->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    public function destroy(Course $course): JsonResponse
    {
        try {
            $course->loadCount('testScoreDetails');

            if ($course->test_score_details_count > 0) {
                return $this->apiResponse('Data tidak bisa dihapus', null, null, Response::HTTP_BAD_REQUEST);
            }

            $course->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}

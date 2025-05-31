<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\ImportRequest;
use App\Http\Requests\Student\StudentRequest;
use App\Imports\StudentImport;
use App\Models\Student;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    use ApiResponse;

    public function index(): View
    {
        $title = 'Siswa';

        return \view('dashboard.student.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Student::query()
                    ->with('schoolYear')
                    ->orderByDesc('created_at');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['full_name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('schoolYear', fn($row) => $row->schoolYear?->year)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="'. route('student.show', $row->username) .'" class="btn btn-icon btn-sm btn-primary"><i class="mdi mdi-eye"></i></a> ';
                        $btn .= '<button type="button" data-username="'. $row->username .'" data-full-name="'. $row->full_name .'" data-exam-number="'. $row->exam_number .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        $btn .= '<button type="button" data-username="'. $row->username .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(StudentRequest $request): RedirectResponse
    {
        try {
            $student = new Student();
            $student->full_name = $request->input('full_name');
            $student->exam_number = $request->input('exam_number');
            $student->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function import(ImportRequest $request): RedirectResponse
    {
        try {
            Excel::import(new StudentImport(), $request->file('file')->getRealPath(), null, \Maatwebsite\Excel\Excel::XLSX);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function show(Student $student)
    {
        return $student;
    }

    public function update(StudentRequest $request, Student $student): JsonResponse
    {
        try {
            $student->full_name = $request->input('full_name');
            $student->exam_number = $request->input('exam_number');
            $student->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    public function destroy(Student $student): JsonResponse
    {
        try {
            $student->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolYear\SchoolYearRequest;
use App\Models\SchoolYear;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SchoolYearController extends Controller
{
    use ApiResponse;

    public function index(): View
    {
        $title = 'Tahun Ajaran';

        return \view('dashboard.school-year.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = SchoolYear::query()
                    ->orderByDesc('created_at');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['first_year', 'last_year'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('year', fn($row) => $row->first_year . '/' . $row->last_year)
                    ->addColumn('announcementDate', fn($row) => Carbon::parse($row->announcemenet_start_date)->isoFormat('DD MMM Y') . '-' . Carbon::parse($row->announcemenet_end_date)->isoFormat('DD MMM Y'))
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        return '<button type="button" data-slug="'. $row->slug .'" data-first-year="'. $row->first_year .'" data-last-year="'. $row->last_year .'" data-announcement-start-date="'. $row->announcement_start_date .'" data-announcement-end-date="'. $row->announcement_end_date .'" data-active="'. $row->is_active .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button>';
                    })
                    ->rawColumns(['is_active', 'action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(SchoolYearRequest $request): RedirectResponse
    {
        try {
            $schoolYear = new SchoolYear();
            $schoolYear->first_year = $request->input('first_year');
            $schoolYear->last_year = $request->input('last_year');
            $schoolYear->announcement_start_date = $request->input('announcement_start_date');
            $schoolYear->announcement_end_date = $request->input('announcement_end_date');
            $schoolYear->is_active = $request->input('is_active');
            $schoolYear->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function update(SchoolYearRequest $request, SchoolYear $schoolYear): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $schoolYear->first_year = $request->input('first_year');
            $schoolYear->last_year = $request->input('last_year');
            $schoolYear->announcement_start_date = $request->input('announcement_start_date');
            $schoolYear->announcement_end_date = $request->input('announcement_end_date');
            $schoolYear->is_active = $request->input('is_active');
            $schoolYear->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }
}

@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">{{ $title }}</h5>
            <a href="{{ route('test-score.create', $schoolYearActive['slug']) }}" class="btn btn-primary" data-bs-toggle="tooltip" title="Tahun Ajaran {{ $schoolYearActive['year'] }}"><i class="mdi mdi-plus me-2"></i>Tambah/Edit</a>
        </div>
    </div>
@endsection
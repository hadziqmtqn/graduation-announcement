@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-datatable">
            <table class="table table-striped text-nowrap" id="datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>TA.</th>
                    <th>No. Ujian</th>
                    <th>Nama Lengkap</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('dashboard.student.modal-create')
    @include('dashboard.student.modal-edit')
    @include('dashboard.student.modal-import')
@endsection

@section('scripts')
    <script src="{{ asset('js/student/datatable.js') }}"></script>
@endsection
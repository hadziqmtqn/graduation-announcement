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
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('dashboard.course.modal-create')
    @include('dashboard.course.modal-edit')
@endsection

@section('scripts')
    <script src="{{ asset('js/course/datatable.js') }}"></script>
@endsection
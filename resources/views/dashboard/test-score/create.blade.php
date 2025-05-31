@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('test-score.index') }}">Nilai Ujian</a> /</span>
        {{ $title }}
    </h4>
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">{{ $title }}</h5>
        </div>
        <form action="{{ route('test-score.store', $schoolYear->slug) }}" method="post" id="formCreate">
            @csrf
            <div class="card-datatable table-responsive">
                <table class="table table-striped w-100 text-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Ujian</th>
                        <th>Nama Siswa</th>
                        @foreach($courses as $course)
                            <th>
                                <div style="margin-right: 100px">{{ $course->code }}</div>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($testScores as $key => $testScore)
                        <input type="hidden" name="student_id[]" id="student-{{ $key }}" value="{{ $testScore['studentId'] }}">
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $testScore['examNumber'] }}</td>
                            <td>{{ $testScore['fullName'] }}</td>
                            @foreach($testScore['scores'] as $indexScore => $score)
                                <input type="hidden" name="course_id[]" value="{{ $score['id'] }}">
                                <td>
                                    <input type="number" name="score[]" class="form-control" id="score-{{ $indexScore }}" value="{{ $score['score'] }}" data-bs-toggle="tooltip" title="{{ $testScore['fullName'] }} - {{ $score['name'] }}">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
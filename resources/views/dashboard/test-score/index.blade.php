@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
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
                        <th>Rata2 Nilai</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($testScores as $key => $testScore)
                        <tr>
                            <input type="hidden" name="student_id[]" id="student-{{ $key }}" value="{{ $testScore['studentId'] }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $testScore['examNumber'] }}</td>
                            <td>{{ $testScore['fullName'] }}</td>
                            @foreach($testScore['scores'] as $indexScore => $score)
                                <td>
                                    <input type="number" name="score[{{ $testScore['studentId'] }}][{{ $score['id'] }}]" class="form-control excel-cell" value="{{ $score['score'] }}" data-bs-toggle="tooltip" title="{{ $testScore['fullName'] }} - {{ $score['name'] }}">
                                </td>
                            @endforeach
                            <td class="fw-bold">{{ $testScore['avgScore'] }}</td>
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputList = Array.from(document.querySelectorAll('.excel-cell'));

            inputList.forEach((input, index) => {
                input.addEventListener('paste', function (e) {
                    e.preventDefault();

                    const clipboardData = e.clipboardData || window.clipboardData;
                    const pastedData = clipboardData.getData('text');
                    const rows = pastedData.trim().split('\n');

                    rows.forEach((row, rowIndex) => {
                        const cols = row.split('\t');

                        cols.forEach((value, colIndex) => {
                            const targetIndex = index + (rowIndex * {{ count($courses) }}) + colIndex;
                            if (inputList[targetIndex]) {
                                inputList[targetIndex].value = value.trim();
                            }
                        });
                    });
                });
            });
        });
    </script>
@endsection
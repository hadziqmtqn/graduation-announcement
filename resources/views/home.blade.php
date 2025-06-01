@extends('master')

@section('content')
    <section class="section-py first-section-pt help-center-header">
        <div class="container">
            <div class="text-center">
                <img src="{{ asset('assets/logo-mikurkid.png') }}" alt="logo" style="width: 150px" class="mb-4">
            </div>
            <h1 class="text-center mb-2 fw-bold">PENGUMUMAN KELULUSAN</h1>
            <h3 class="text-center mb-2">{{ config('app.name') }}</h3>
            <h4 class="text-center mb-2">Tahun Ajaran {{ $schoolYearActive['year'] }}</h4>
            <div data-start-date="{{ $schoolYearActive['announcementStartDate'] }}" data-end-date="{{ $schoolYearActive['announcementEndDate'] }}"></div>

            <h1 class="text-center text-primary display-6 fw-semibold" id="countdown-title" style="margin-top: 3em"></h1>
            <div id="countdown-timer" class="text-center mt-3"></div>

            @if($schoolYearActive['announcementIsOpen'])
                <form onsubmit="return false" id="form">
                    <div class="input-wrapper my-3 input-group input-group-lg input-group-merge position-relative mx-auto">
                        <span class="input-group-text" id="basic-addon1"><i class="tf-icons mdi mdi-magnify"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan Nomor Ujian" aria-label="Nomor Ujian" aria-describedby="basic-addon1" required>
                        <button type="button" class="btn btn-primary waves-light waves-effect" data-bs-toggle="modal" data-bs-target="#testResultModal">Cari</button>
                    </div>
                </form>
            @endif
        </div>
    </section>

    <div class="modal fade" id="testResultModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body p-md-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="d-flex justify-content-center" style="margin-bottom: 5rem">
                        <div class="avatar" style="width: 6rem; height: 6rem">
                            <img src="{{ asset('assets/approved.png') }}" alt="Approval" class="rounded-circle">
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="h4 fw-bold mb-0" id="fullName">Nama lengkap</div>
                        <div id="examNumber">0920-20291-2002-10022</div>
                        <div class="alert alert-success alert-dismissible" style="margin-top: 3rem" role="alert">
                            <div class="fw-bold h1" style="color: #109854">LULUS</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/home/countdown-time.js') }}"></script>
@endsection
<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Tambah {{ $title }} TA. {{ $schoolYearActive['year'] }}</h3>
                </div>
                <form action="{{ route('student.store') }}" id="formCreate" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="post">
                    @csrf
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" placeholder="Nama Lengkap">
                            <label for="full_name">Nama Lengkap</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="exam_number" id="exam_number" class="form-control" value="{{ old('exam_number') }}" placeholder="Nomor Ujian">
                            <label for="exam_number">Nomor Ujian</label>
                        </div>
                        @include('layouts.session')
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

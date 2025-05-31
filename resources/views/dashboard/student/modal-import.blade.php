<div class="modal fade" id="modalImport" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Import {{ $title }} TA. {{ $schoolYearActive['year'] }}</h3>
                </div>
                <form action="{{ route('student.import') }}" id="formImport" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="alert alert-primary alert-dismissible mb-3" role="alert">
                            <h4 class="alert-heading d-flex align-items-center">
                                <i class="mdi mdi-clipboard-outline mdi-24px me-2"></i>Panduan
                            </h4>
                            <ul>
                                <li>File yang diizinkan berupa .xls dan .xlsx, dan maksimal 200KB.</li>
                                <li>Nama kolom tidak boleh diubah.</li>
                                <li>
                                    Kolom wajib diisi:
                                    <ul>
                                        <li>nomor_ujian</li>
                                        <li>nama_lengkap</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="file" name="file" id="file" class="form-control" accept="xls,.xlsx">
                            <label for="file">File Excel</label>
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

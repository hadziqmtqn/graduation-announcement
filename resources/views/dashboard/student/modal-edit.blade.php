<div class="modal fade" id="modalEdit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Edit {{ $title }}</h3>
                </div>
                <form onsubmit="return false" id="formEdit" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="full_name" id="editFullName" class="form-control" placeholder="Nama Lengkap">
                            <label for="editFullName">Nama Lengkap</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="exam_number" id="editExamNumber" class="form-control" placeholder="Nomor Ujian">
                            <label for="editExamNumber">Nomor Ujian</label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-edit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

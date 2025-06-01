document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form');
    const searchBtn = form.querySelector('button[type="button"]');
    const examInput = form.querySelector('input[name="exam_number"]');

    searchBtn.addEventListener('click', async function () {
        const exam_number = examInput.value.trim();
        if (!exam_number) {
            examInput.focus();
            Swal.fire({
                text: 'Nomor Ujian harus diisi',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                },
                buttonsStyling: false,
            });
            return;
        }

        // Disable button while processing
        searchBtn.disabled = true;
        searchBtn.textContent = 'Memproses...';

        try {
            // CSRF token dari meta tag (Laravel)
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch('/test-result', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {})
                },
                body: new URLSearchParams({
                    exam_number: exam_number,
                    ...(csrfToken ? { _token: csrfToken } : {})
                })
            });

            const result = await response.json();

            if (result.success && result.data) {
                // Set modal content
                document.getElementById('fullName').textContent = result.data.fullName || '-';
                document.getElementById('examNumber').textContent = result.data.examNumber || '-';
                document.getElementById('avgScore').textContent = result.data.avgScore || '-';
                document.getElementById('announcementDate').textContent = 'Tanggal ' + (result.data.announcementDate || '-');

                // Show Bootstrap 5 modal
                const modalEl = document.getElementById('testResultModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            } else {
                Swal.fire({
                    title: result.message || 'Data tidak ditemukan',
                    icon: result.type === 'error' ? 'error' : 'info',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                    },
                    buttonsStyling: false,
                });
            }
        } catch (e) {
            Swal.fire({
                text: 'Terjadi kesalahan. Silakan coba lagi.',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                },
                buttonsStyling: false,
            });
        } finally {
            searchBtn.disabled = false;
            searchBtn.textContent = 'Cari';
        }
    });
});
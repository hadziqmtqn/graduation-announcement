$(function () {
    const table = '#datatable';

    const dataTable = $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[1, 'asc']],
        ajax: {
            url: "/course/datatable",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function (d) {
                d.search = $(table + '_filter ' + 'input[type="search"]').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'is_active', name: 'is_active', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        dom:
            '<"row mx-2"' +
            '<"col-md-2"<"me-3"l>>' +
            '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0 gap-3"fB>>' +
            '>t' +
            '<"row mx-2"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        buttons: [
            {
                text: '<i class="mdi mdi-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Baru</span>',
                className: 'btn btn-primary waves-effect waves-light me-2',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#modalCreate',
                }
            },
        ],
    });

    function reloadTable() {
        const currentPage = dataTable.page();
        dataTable.ajax.reload();
        dataTable.page(currentPage).draw('page');
    }

    $('#modalEdit').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const slug = button.data('slug');
        const code = button.data('code');
        const name = button.data('name');
        const active = button.data('active');

        // Isi nilai modal
        $('#editCode').val(code);
        $('#editName').val(name);

        if (active === 1) {
            $('#activeSchedule').prop('checked', true);
        } else {
            $('#notActiveSchedule').prop('checked', true);
        }

        // Atur event handler untuk tombol "Simpan"
        $('#btn-edit').off('click').on('click', function() {
            blockUi();
            toastrOption();

            // Clear previous errors
            const form = document.getElementById('formEdit');
            form.querySelectorAll('.is-invalid').forEach(element => {
                element.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(element => {
                element.remove();
            });

            // menggunakan axios
            axios.put(`/course/${slug}/update`, $('#formEdit').serialize())
                .then(response => {
                    unBlockUi();
                    $('#modalEdit').modal('hide');
                    toastr.success(response.data.message);
                    reloadTable();
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        const errors = error.response.data.errors; // Perubahan ada di sini
                        for (const key in errors) {
                            const input = form.querySelector(`[name="${key}"]`);
                            if (input) {
                                // Tambahkan kelas error
                                input.classList.add('is-invalid');

                                // Buat elemen pesan error
                                const errorMessage = document.createElement('div');
                                errorMessage.classList.add('invalid-feedback');
                                errorMessage.innerHTML = errors[key].join('<br>');

                                // Tampilkan di bawah field input
                                if (input.parentNode.classList.contains('form-floating')) {
                                    input.parentNode.appendChild(errorMessage);
                                } else {
                                    input.parentNode.insertBefore(errorMessage, input.nextSibling);
                                }
                            }
                        }

                        // Tampilkan ringkasan pesan error
                        toastr.error(error.response.data.message);

                    } else {
                        toastr.error(error.response.data.message);
                    }
                    unBlockUi();
                });
        });
    });

    dataTable.off('click').on('click', '.delete', function () {
        let slug = $(this).data('slug');
        let url = '/course/' + slug + '/delete';
        let token = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Peringatan!',
            text: "Apakah Anda ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!',
            customClass: {
                confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect'
            },
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                blockUi();

                axios.delete(url, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                }).then(function (response) {
                    toastr.success(response.data.message);
                    reloadTable();
                    unBlockUi();
                }).catch(function (error) {
                    unBlockUi();
                    toastr.error(error.response.data.message);
                });
            }
        });
    });
});
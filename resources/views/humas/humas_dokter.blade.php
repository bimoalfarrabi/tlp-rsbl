@extends('_Layouts.main')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mt-4 fw-bold text-dark">Manajemen Dokter</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-primary">Dashboard</a></li>
                <li class="breadcrumb-item active">Daftar Dokter</li>
            </ol>
        </div>
        <div>
            <button id="exportPDF" class="btn btn-outline-info shadow-sm fw-bold px-4">
                <i class="fas fa-file-pdf me-2"></i> Export PDF
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Form Section -->
        <div class="col-xl-4 col-md-5">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-subtle p-2 rounded-3 me-2" style="background-color: #e0f2fe;">
                            <i class="fas fa-user-md text-info"></i>
                        </div>
                        <h6 class="m-0 fw-bold">Tambah Dokter Baru</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form id="addDokterForm" action="{{ route('store.dokter') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label small fw-bold text-muted text-uppercase">Nama Lengkap & Gelar</label>
                            <input type="text" class="form-control bg-light border-0 px-3 py-2" id="nama" name="nama" placeholder="Contoh: dr. Budi, Sp.A" required>
                        </div>

                        <div class="nomor_hp_container">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nomor HP / WhatsApp</label>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 px-3 py-2" name="nomor_hp[]" placeholder="Masukkan nomor HP">
                                    <button class="btn btn-success add-nomor-hp" type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mt-3 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan Data
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-xl-8 col-md-7">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle p-2 rounded-3 me-2">
                            <i class="fas fa-address-card text-primary"></i>
                        </div>
                        <h6 class="m-0 fw-bold">Database Dokter</h6>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive p-4">
                        <table id="tableDokter" class="table table-hover align-middle w-100">
                            <thead>
                                <tr>
                                    <th class="text-center" width="50">NO</th>
                                    <th>NAMA DOKTER</th>
                                    <th class="text-center">NOMOR HP</th>
                                    <th class="text-center" width="150">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- load via ajax --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        var table = $('#tableDokter').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            language: {
                "search": "",
                "searchPlaceholder": "Cari dokter...",
                "lengthMenu": "_MENU_",
                "paginate": {
                    "next": "<i class='fas fa-chevron-right'></i>",
                    "previous": "<i class='fas fa-chevron-left'></i>"
                }
            },
            ajax: { url: "{{ route('humas.dokter') }}", type: "GET" },
            columns: [
                {
                    data: null,
                    className: 'text-center text-muted small',
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'nama', className: 'fw-bold text-dark' },
                {
                    data: 'nomor_hp',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (Array.isArray(data)) return data.join(', ') || '<span class="text-muted">Empty</span>';
                        return '<span class="text-muted">Empty</span>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group shadow-sm">
                                <button data-id="${row.id}" id="editDokter" class="btn btn-white text-primary border-end px-3 py-2" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button data-id="${row.id}" id="deleteDokter" class="btn btn-white text-danger px-3 py-2" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            drawCallback: function() {
                $('.dataTables_filter input').addClass('form-control shadow-sm border-0 bg-light px-3 py-2 rounded-pill');
                $('.dataTables_length select').addClass('form-select border-0 bg-light shadow-sm');
            }
        });

        $(document).on('click', '.add-nomor-hp', function() {
            var newInput = `
                <div class="mb-3 input-group">
                    <input type="text" class="form-control bg-light border-0 px-3 py-2" name="nomor_hp[]" placeholder="Masukkan nomor HP">
                    <button class="btn btn-danger remove-nomor-hp" type="button"><i class="fas fa-minus"></i></button>
                </div>`;
            $('.nomor_hp_container').append(newInput);
        });

        $(document).on('click', '.remove-nomor-hp', function() { $(this).closest('.input-group').parent().remove(); });

        $('#addDokterForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data dokter ditambahkan', timer: 1500, showConfirmButton: false, toast: true, position: 'top-end' });
                        $('#addDokterForm')[0].reset();
                        $('.nomor_hp_container .input-group:not(:first)').remove();
                        table.ajax.reload();
                    }
                }
            });
        });

        $('#tableDokter').on('click', '#deleteDokter', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Dokter?',
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/panel/dokter/${id}/destroy`,
                        type: 'GET',
                        success: function() {
                            Swal.fire({ icon: 'success', title: 'Terhapus!', timer: 1000, showConfirmButton: false });
                            table.ajax.reload();
                        }
                    });
                }
            });
        });

        $('#tableDokter').on('click', '#editDokter', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: `/panel/dokter/${id}/edit`,
                type: 'GET',
                success: function(response) {
                    var nomorHpInputs = response.nomor_hp.map((nomor, index) => `
                        <div class="mb-3 input-group">
                            <input type="text" class="form-control bg-light border-0 px-3 py-2" name="nomor_hp[]" value="${nomor}">
                            ${index > 0 ? '<button class="btn btn-danger remove-nomor-hp-edit" type="button"><i class="fas fa-minus"></i></button>' : ''}
                        </div>
                    `).join('');

                    var modalHtml = `
                        <div class="modal fade" id="editDokterModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold">Edit Data Dokter</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form id="editDokterForm">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="id" value="${response.id}">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">NAMA LENGKAP</label>
                                                <input type="text" class="form-control bg-light border-0 px-3 py-2" name="nama" value="${response.nama}" required>
                                            </div>
                                            <div class="nomor_hp_container_edit">
                                                <label class="form-label small fw-bold text-muted">NOMOR HP</label>
                                                ${nomorHpInputs}
                                                <button class="btn btn-sm btn-outline-success add-nomor-hp-edit w-100" type="button">
                                                    <i class="fas fa-plus me-1"></i> Tambah Nomor
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4 pt-0">
                                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>`;
                    $('#editDokterModal').remove();
                    $('body').append(modalHtml);
                    new bootstrap.Modal(document.getElementById('editDokterModal')).show();
                }
            });
        });

        $(document).on('click', '.add-nomor-hp-edit', function() {
            var newInput = `
                <div class="mb-3 input-group">
                    <input type="text" class="form-control bg-light border-0 px-3 py-2" name="nomor_hp[]" placeholder="Nomor HP">
                    <button class="btn btn-danger remove-nomor-hp-edit" type="button"><i class="fas fa-minus"></i></button>
                </div>`;
            $(this).before(newInput);
        });

        $(document).on('click', '.remove-nomor-hp-edit', function() { $(this).closest('.input-group').remove(); });

        $(document).on('submit', '#editDokterForm', function(e) {
            e.preventDefault();
            var id = $('input[name="id"]').val();
            $.ajax({
                url: `/panel/dokter/${id}/update`,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', timer: 1500, showConfirmButton: false });
                        $('#editDokterModal').modal('hide');
                        table.ajax.reload();
                    }
                }
            });
        });

        $('#exportPDF').on('click', function() { window.location.href = "{{ route('export.dokter') }}"; });
    });
</script>
@endpush

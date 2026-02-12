@extends('_Layouts.main')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mt-4 fw-bold text-dark">Manajemen Memori Telepon</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-primary">Dashboard</a></li>
                <li class="breadcrumb-item active">Daftar Memori</li>
            </ol>
        </div>
        <div>
            <button id="exportPDF" class="btn btn-outline-danger shadow-sm fw-bold">
                <i class="fas fa-file-pdf me-2"></i> Export ke PDF
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Form Section -->
        <div class="col-xl-4 col-md-5">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle p-2 rounded-3 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            <i class="fas fa-plus text-primary"></i>
                        </div>
                        <h6 class="m-0 fw-bold">Tambah Memori Baru</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form id="addExtensionForm" action="{{ route('super_admin.memori') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="ext" class="form-label small fw-bold text-muted">KODE MEMORI</label>
                            <input type="text" class="form-control bg-light border-0 px-3 py-2" id="ext" name="memori" placeholder="Contoh: *2201" required>
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="form-label small fw-bold text-muted">NAMA / UNIT</label>
                            <input type="text" class="form-control bg-light border-0 px-3 py-2" id="nama" name="nama" placeholder="Masukkan nama unit" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">
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
                        <div class="bg-primary-subtle p-2 rounded-3 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            <i class="fas fa-address-book text-primary"></i>
                        </div>
                        <h6 class="m-0 fw-bold">Database Memori</h6>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive p-4">
                        <table id="tableExtension" class="table table-hover align-middle w-100">
                            <thead>
                                <tr>
                                    <th class="text-center" width="50">NO</th>
                                    <th class="text-center" width="100">MEMORI</th>
                                    <th>NAMA / UNIT</th>
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

        var table = $('#tableExtension').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            language: {
                "search": "",
                "searchPlaceholder": "Cari memori...",
                "lengthMenu": "_MENU_",
                "paginate": {
                    "next": "<i class='fas fa-chevron-right'></i>",
                    "previous": "<i class='fas fa-chevron-left'></i>"
                }
            },
            ajax: { 
                url: "{{ route('super_admin.extension') }}", 
                type: "GET",
                error: function (xhr, error, code)
                {
                    console.log(xhr.responseText);
                }
            },
            columns: [
                {
                    data: null,
                    className: 'text-center text-muted small',
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'memori', className: 'text-center fw-bold text-primary' },
                { data: 'nama', className: 'fw-semibold text-dark' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group shadow-sm">
                                <button data-id="${row.id}" id="editExtension" class="btn btn-white text-primary border-end px-3 py-2" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button data-id="${row.id}" id="deleteExtension" class="btn btn-white text-danger px-3 py-2" title="Hapus">
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

        $('#addExtensionForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data memori ditambahkan', timer: 1500, showConfirmButton: false, toast: true, position: 'top-end' });
                        $('#addExtensionForm')[0].reset();
                        table.ajax.reload();
                    }
                }
            });
        });

        $('#tableExtension').on('click', '#deleteExtension', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Memori?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/panel-super-admin/memori/${id}/destroy`,
                        type: 'GET',
                        success: function() {
                            Swal.fire({ icon: 'success', title: 'Dihapus!', timer: 1000, showConfirmButton: false });
                            table.ajax.reload();
                        }
                    });
                }
            });
        });

        $('#tableExtension').on('click', '#editExtension', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: `/panel-super-admin/memori/${id}/edit`,
                type: 'GET',
                success: function(response) {
                    var modalHtml = `
                        <div class="modal fade" id="editExtensionModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold">Edit Memori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form id="editExtensionForm">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="id" value="${response.id}">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted text-uppercase">KODE MEMORI</label>
                                                <input type="text" class="form-control bg-light border-0 px-3 py-2" name="memori" value="${response.memori}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted text-uppercase">NAMA / UNIT</label>
                                                <input type="text" class="form-control bg-light border-0 px-3 py-2" name="nama" value="${response.nama}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0 p-4">
                                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>`;
                    $('#editExtensionModal').remove();
                    $('body').append(modalHtml);
                    new bootstrap.Modal(document.getElementById('editExtensionModal')).show();
                }
            });
        });

        $(document).on('submit', '#editExtensionForm', function(e) {
            e.preventDefault();
            var id = $('input[name="id"]').val();
            $.ajax({
                url: `/panel-super-admin/memori/${id}/update`,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', timer: 1500, showConfirmButton: false });
                        $('#editExtensionModal').modal('hide');
                        table.ajax.reload();
                    }
                }
            });
        });

        $('#exportPDF').on('click', function() { window.location.href = "{{ route('export-memori') }}"; });
    });
</script>
@endpush

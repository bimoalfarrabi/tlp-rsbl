@extends('_Layouts.main')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mt-4 fw-bold text-dark">Manajemen Extension</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-primary">Dashboard</a></li>
                <li class="breadcrumb-item active">Daftar Extension</li>
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
                        <div class="bg-primary-subtle p-2 rounded-3 me-2">
                            <i class="fas fa-plus text-primary"></i>
                        </div>
                        <h6 class="m-0 fw-bold">Tambah Extension Baru</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form id="addExtensionForm" action="{{ route('store.extension') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="ext" class="form-label small fw-bold text-muted">NOMOR EXTENSION</label>
                            <input type="text" class="form-control bg-light border-0 px-3 py-2" id="ext" name="ext" placeholder="Contoh: 101" required>
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="form-label small fw-bold text-muted">NAMA RUANGAN / UNIT</label>
                            <input type="text" class="form-control bg-light border-0 px-3 py-2" id="nama" name="nama" placeholder="Masukkan nama ruangan" required>
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
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle p-2 rounded-3 me-2">
                            <i class="fas fa-table text-primary"></i>
                        </div>
                        <h6 class="m-0 fw-bold">Database Extension</h6>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive p-4">
                        <table id="tableExtension" class="table table-hover align-middle w-100">
                            <thead>
                                <tr>
                                    <th class="text-center" width="50">NO</th>
                                    <th class="text-center" width="100">EXT</th>
                                    <th>NAMA RUANGAN</th>
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#tableExtension').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            language: {
                "search": "",
                "searchPlaceholder": "Cari data...",
                "lengthMenu": "_MENU_",
                "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                "paginate": {
                    "next": "<i class='fas fa-chevron-right'></i>",
                    "previous": "<i class='fas fa-chevron-left'></i>"
                }
            },
            ajax: {
                url: "{{ route('admin.extension') }}",
                type: "GET"
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
                {
                    data: 'ext',
                    className: 'text-center fw-bold text-primary'
                },
                {
                    data: 'nama',
                    className: 'fw-semibold text-dark'
                },
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
            order: [[1, 'asc']],
            responsive: true,
            drawCallback: function() {
                $('.dataTables_filter input').addClass('form-control shadow-sm border-0 bg-light px-3 py-2 rounded-pill');
                $('.dataTables_length select').addClass('form-select border-0 bg-light shadow-sm');
            }
        });

        // Event Handlers (Add, Delete, Edit)
        $('#addExtensionForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Tersimpan!',
                            text: 'Data extension berhasil ditambahkan',
                            timer: 1500,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                        $('#addExtensionForm')[0].reset();
                        table.ajax.reload();
                    }
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Kesalahan', text: 'Gagal menyimpan data.' });
                }
            });
        });

        $('#tableExtension').on('click', '#deleteExtension', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/panel/extension/${id}/destroy`,
                        type: 'GET',
                        success: function() {
                            Swal.fire({ icon: 'success', title: 'Dihapus!', text: 'Data telah berhasil dihapus.', timer: 1000, showConfirmButton: false });
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
                url: `/panel/extension/${id}/edit`,
                type: 'GET',
                success: function(response) {
                    var modalHtml = `
                        <div class="modal fade" id="editExtensionModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold">Edit Extension</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form id="editExtensionForm">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="id" value="${response.id}">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">EXTENSION</label>
                                                <input type="text" class="form-control bg-light border-0 px-3 py-2" name="ext" value="${response.ext}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">NAMA RUANGAN</label>
                                                <input type="text" class="form-control bg-light border-0 px-3 py-2" name="nama" value="${response.nama}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0 p-4">
                                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Update Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;
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
                url: `/panel/extension/${id}/update`,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data diperbarui', timer: 1500, showConfirmButton: false });
                        $('#editExtensionModal').modal('hide');
                        table.ajax.reload();
                    }
                }
            });
        });

        $('#exportPDF').on('click', function() {
            window.location.href = "{{ route('export') }}";
        });
    });
</script>
@endpush


    <script type="text/javascript">
        $(document).ready(function() {
            // Setup AJAX CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTable
            var table = $('#tableExtension').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Semua"]
                ],
                language: {
                    "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "loadingRecords": "Sedang memuat...",
                    "processing": "Sedang memproses...",
                    "search": "Cari Nomor EXT atau Nama Ruangan:",
                    "zeroRecords": "Tidak ditemukan data yang sesuai",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    "aria": {
                        "sortAscending": ": aktifkan untuk mengurutkan kolom ke atas",
                        "sortDescending": ": aktifkan untuk mengurutkan kolom menurun"
                    },
                    "autoFill": {
                        "fill": "Isi semua sel dengan <i>%d<\/i>",
                        "fillHorizontal": "Isi sel secara horizontal",
                        "fillVertical": "Isi sel secara vertikal",
                        "cancel": "Batal",
                        "info": "Info"
                    },
                    "buttons": {
                        "collection": "Kumpulan <span class='ui-button-icon-primary ui-icon ui-icon-triangle-1-s'\/>",
                        "colvis": "Visibilitas Kolom",
                        "colvisRestore": "Kembalikan visibilitas",
                        "copy": "Salin",
                        "copySuccess": {
                            "_": "%d baris disalin ke papan klip",
                            "1": "satu baris disalin ke papan klip"
                        },
                        "copyTitle": "Salin ke Papan klip",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "Tampilkan semua baris",
                            "_": "Tampilkan %d baris",
                            "1": "Tampilkan satu baris"
                        },
                        "pdf": "PDF",
                        "print": "Cetak",
                        "copyKeys": "Tekan ctrl atau u2318 + C untuk menyalin tabel ke papan klip.<br \/><br \/>Untuk membatalkan, klik pesan ini atau tekan esc.",
                        "createState": "Tambahkan Data",
                        "removeAllStates": "Hapus Semua Data",
                        "removeState": "Hapus Data",
                        "renameState": "Rubah Nama",
                        "savedStates": "SImpan Data",
                        "stateRestore": "Publihkan Data",
                        "updateState": "Perbaharui data"
                    },
                    "searchBuilder": {
                        "add": "Tambah Kondisi",
                        "button": {
                            "0": "Cari Builder",
                            "_": "Cari Builder (%d)"
                        },
                        "clearAll": "Bersihkan Semua",
                        "condition": "Kondisi",
                        "data": "Data",
                        "deleteTitle": "Hapus filter",
                        "leftTitle": "Ke Kiri",
                        "logicAnd": "Dan",
                        "logicOr": "Atau",
                        "rightTitle": "Ke Kanan",
                        "title": {
                            "0": "Cari Builder",
                            "_": "Cari Builder (%d)"
                        },
                        "value": "Nilai",
                        "conditions": {
                            "date": {
                                "after": "Setelah",
                                "before": "Sebelum",
                                "between": "Diantara",
                                "empty": "Kosong",
                                "equals": "Sama dengan",
                                "not": "Tidak sama",
                                "notBetween": "Tidak diantara",
                                "notEmpty": "Tidak kosong"
                            },
                            "number": {
                                "empty": "Kosong",
                                "equals": "Sama dengan",
                                "gt": "Lebih besar dari",
                                "gte": "Lebih besar atau sama dengan",
                                "lt": "Lebih kecil dari",
                                "lte": "Lebih kecil atau sama dengan",
                                "not": "Tidak sama",
                                "notEmpty": "Tidak kosong",
                                "between": "Di antara",
                                "notBetween": "Tidak di antara"
                            },
                            "string": {
                                "contains": "Berisi",
                                "empty": "Kosong",
                                "endsWith": "Diakhiri dengan",
                                "not": "Tidak sama",
                                "notEmpty": "Tidak kosong",
                                "startsWith": "Diawali dengan",
                                "equals": "Sama dengan",
                                "notContains": "Tidak Berisi",
                                "notStartsWith": "Tidak diawali Dengan",
                                "notEndsWith": "Tidak diakhiri Dengan"
                            },
                            "array": {
                                "equals": "Sama dengan",
                                "empty": "Kosong",
                                "contains": "Berisi",
                                "not": "Tidak",
                                "notEmpty": "Tidak kosong",
                                "without": "Tanpa"
                            }
                        }
                    },
                    "searchPanes": {
                        "count": "{total}",
                        "countFiltered": "{shown} ({total})",
                        "collapse": {
                            "0": "Panel Pencarian",
                            "_": "Panel Pencarian (%d)"
                        },
                        "emptyPanes": "Tidak Ada Panel Pencarian",
                        "loadMessage": "Memuat Panel Pencarian",
                        "clearMessage": "Bersihkan",
                        "title": "Saringan Aktif - %d",
                        "showMessage": "Tampilkan",
                        "collapseMessage": "Ciutkan"
                    },
                    "infoThousands": ",",
                    "datetime": {
                        "previous": "Sebelumnya",
                        "next": "Selanjutnya",
                        "hours": "Jam",
                        "minutes": "Menit",
                        "seconds": "Detik",
                        "unknown": "-",
                        "amPm": [
                            "am",
                            "pm"
                        ],
                        "weekdays": [
                            "Min",
                            "Sen",
                            "Sel",
                            "Rab",
                            "Kam",
                            "Jum",
                            "Sab"
                        ],
                        "months": [
                            "Januari",
                            "Februari",
                            "Maret",
                            "April",
                            "Mei",
                            "Juni",
                            "Juli",
                            "Agustus",
                            "September",
                            "Oktober",
                            "November",
                            "Desember"
                        ]
                    },
                    "editor": {
                        "close": "Tutup",
                        "create": {
                            "button": "Tambah",
                            "submit": "Tambah",
                            "title": "Tambah inputan baru"
                        },
                        "remove": {
                            "button": "Hapus",
                            "submit": "Hapus",
                            "confirm": {
                                "_": "Apakah Anda yakin untuk menghapus %d baris?",
                                "1": "Apakah Anda yakin untuk menghapus 1 baris?"
                            },
                            "title": "Hapus inputan"
                        },
                        "multi": {
                            "title": "Beberapa Nilai",
                            "info": "Item yang dipilih berisi nilai yang berbeda untuk input ini. Untuk mengedit dan mengatur semua item untuk input ini ke nilai yang sama, klik atau tekan di sini, jika tidak maka akan mempertahankan nilai masing-masing.",
                            "restore": "Batalkan Perubahan",
                            "noMulti": "Masukan ini dapat diubah satu per satu, tetapi bukan bagian dari grup."
                        },
                        "edit": {
                            "title": "Edit inputan",
                            "submit": "Edit",
                            "button": "Edit"
                        },
                        "error": {
                            "system": "Terjadi kesalahan pada system. (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Informasi Selebihnya<\/a>)."
                        }
                    },
                    "stateRestore": {
                        "creationModal": {
                            "button": "Buat",
                            "columns": {
                                "search": "Pencarian Kolom",
                                "visible": "Visibilitas Kolom"
                            },
                            "name": "Nama:",
                            "order": "Penyortiran",
                            "search": "Pencarian",
                            "select": "Pemilihan",
                            "title": "Buat State Baru",
                            "toggleLabel": "Termasuk:",
                            "paging": "Nomor Halaman",
                            "scroller": "Posisi Skrol",
                            "searchBuilder": "Cari Builder"
                        },
                        "emptyError": "Nama tidak boleh kosong.",
                        "removeConfirm": "Apakah Anda yakin ingin menghapus %s?",
                        "removeJoiner": "dan",
                        "removeSubmit": "Hapus",
                        "renameButton": "Ganti Nama",
                        "renameLabel": "Nama Baru untuk %s:",
                        "duplicateError": "Nama State ini sudah ada.",
                        "emptyStates": "Tidak ada State yang disimpan.",
                        "removeError": "Gagal menghapus State.",
                        "removeTitle": "Penghapusan State",
                        "renameTitle": "Ganti nama State"
                    },
                    "decimal": ",",
                    "searchPlaceholder": "kata kunci pencarian",
                    "select": {
                        "cells": {
                            "1": "1 sel dipilih",
                            "_": "%d sel dipilih"
                        },
                        "columns": {
                            "1": "1 kolom dirpilih",
                            "_": "%d kolom dipilih"
                        },
                        "rows": {
                            "1": "1 baris dipilih",
                            "_": "%d baris dipilih"
                        }
                    },
                    "thousands": "."
                },
                drawCallback: function(settings) {
                    var info = $('#tableExtension_info');
                    info.prepend(`
        <div class="info-instructions">
            1. Menghubungi Ruangan Dalam Gedung Managemen RSUD : <strong class="fw-bold">Angkat Gagang - Tekan EXT yang akan dituju.</strong><br>
            2. Menghubungi Kantor TU (Timur) ke RSUD Blambangan : <strong class="fw-bold">Tekan 88 - Tekan EXT yang akan dituju.</strong>
        </div>
    `);
                },
                ajax: {
                    url: "{{ route('admin.extension') }}",
                    type: "GET",
                    data: function(d) {
                        return d;
                    }
                },
                columns: [{
                        data: null,
                        name: 'no',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'ext',
                        name: 'ext'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <a href="#" data-id="${row.id}" id="editExtension" class="btn btn-primary btn-sm">Edit</a>
                                <a href="#" data-id="${row.id}" id="deleteExtension" class="btn btn-danger btn-sm">Hapus</a>
                            `;
                        }
                    }
                ],
                order: [
                    [1, 'asc']
                ],
                columnDefs: [{
                        targets: -1,
                        className: 'text-center',
                        width: '10%'
                    },
                    {
                        targets: 1,
                        className: 'text-center'
                    },
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '5%'
                    }
                ],
                responsive: true,
                rowCallback: function(row, data, index) {
                    $('td:eq(0)', row).html(index + 1);
                },
            });

            // Add Extension Form Submission
            $('#addExtensionForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data extension berhasil ditambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#addExtensionForm')[0].reset();
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.error;
                            let errorMessage = Object.values(errors).flat().join('\n');

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: errorMessage
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan! Silakan coba lagi.',
                            });
                        }
                    }
                });
            });

            // Delete Extension
            $('#tableExtension').on('click', '#deleteExtension', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda tidak akan dapat mengembalikan ini!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/panel/extension/${id}/destroy`,
                            type: 'GET',
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data extension berhasil dihapus',
                                });
                                table.ajax.reload();
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan! Silakan coba lagi.',
                                });
                            }
                        });
                    }
                });
            });

            // Edit Extension - Open Modal
            $('#tableExtension').on('click', '#editExtension', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    url: `/panel/extension/${id}/edit`,
                    type: 'GET',
                    success: function(response) {
                        // Create dynamic edit modal
                        var modalHtml = `
                            <div class="modal fade" id="editExtensionModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Extension</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form id="editExtensionForm">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="${response.id}">
                                                <div class="mb-3">
                                                    <label for="edit_ext" class="form-label">Extension</label>
                                                    <input type="text" class="form-control" id="edit_ext" name="ext" value="${response.ext}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_nama" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="edit_nama" name="nama" value="${response.nama}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;

                        // Remove previous modal and append new one
                        $('#editExtensionModal').remove();
                        $('body').append(modalHtml);

                        // Show modal
                        new bootstrap.Modal(document.getElementById('editExtensionModal'))
                            .show();
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan! Silakan coba lagi.',
                        });
                    }
                });
            });

            // Submit Edit Extension Form
            $(document).on('submit', '#editExtensionForm', function(e) {
                e.preventDefault();
                var id = $('input[name="id"]').val();

                $.ajax({
                    url: `/panel/extension/${id}/update`,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data extension berhasil diupdate',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#editExtensionModal').modal('hide');
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.error;
                            let errorMessage = Object.values(errors).flat().join('\n');

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: errorMessage
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan! Silakan coba lagi.',
                            });
                        }
                    }
                });
            });
            $('#exportPDF').on('click', function() {
                window.location.href = "{{ route('export') }}";
            });
        });
    </script>

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>

</html>

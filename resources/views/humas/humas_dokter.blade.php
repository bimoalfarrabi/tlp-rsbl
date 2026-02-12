<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Phone Ext RSBL</title>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Scripts JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        .dataTables_wrapper {
            width: 100%;
            overflow-x: auto;
        }

        #tableDokter {
            width: 100% !important;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand with Logo and Text -->
        <a class="navbar-brand ps-3 d-flex align-items-center" href="#" style="gap: 10px;">
            <img src="{{ asset('assets/img/rsud_logo.png') }}" alt="RSUD Logo" style="height: 40px; width: auto;">
            <span style="font-size: 1.25rem; font-weight: 500;">Phone Ext RSBL</span>
        </a>

        <!-- Sidebar Toggle -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        @if (auth()->user()->role == 'super_admin')
                            <a class="nav-link" href="{{ route('super_admin.extension') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Daftar Memori
                            </a>
                            <a class="nav-link" href="{{ route('admin.extension') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Daftar Extension
                            </a>
                            <a class="nav-link" href="{{ route('humas.dokter') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Daftar Dokter
                            </a>
                        @elseif(auth()->user()->role == 'admin')
                            <!-- Untuk Admin yang hanya bisa mengakses Extension -->
                            <a class="nav-link" href="{{ route('admin.extension') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Daftar Extension
                            </a>
                        @elseif(auth()->user()->role == 'humas')
                            <!-- Untuk Humas yang bisa mengakses Extension dan Dokter -->
                            <a class="nav-link" href="{{ route('humas.extension') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Daftar Extension
                            </a>
                            <a class="nav-link" href="{{ route('humas.dokter') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Daftar Dokter
                            </a>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard Humas</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <hr>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tambah Dokter
                        </div>
                        <div class="card-body">
                            <form id="addDokterForm" action="{{ route('store.dokter') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Dokter</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="nomor_hp_container">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nomor_hp[]"
                                                placeholder="Masukkan nomor HP">
                                            <button class="btn btn-success add-nomor-hp" type="button">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Dokter
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="mb-2">
                                    <button id="exportPDF" class="btn btn-info">Export PDF</button>
                                </div>
                                <table id="tableDokter" class="table table-striped table-hover table-bordered"
                                    style="width: 100%;">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nomor HP</th>
                                            <th>Aksi</th>
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
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; TLP EXTENSION 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // Setup AJAX CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTable
            var table = $('#tableDokter').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ajax: {
                    url: "{{ route('humas.dokter') }}",
                    type: "GET"
                },
                pagelength: 10,
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
                    "search": "Cari Nama Dokter atau Nomor HP:",
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
                responsive: true,
                columns: [{
                        data: null,
                        name: 'no',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        searchable: true,
                    },
                    {
                        data: 'nomor_hp',
                        name: 'nomor_hp',
                        searchable: true,
                        render: function(data, type, row) {
                            // Jika data adalah array sederhana
                            if (Array.isArray(data)) {
                                return data.join(', ') || 'Tidak ada nomor HP';
                            }

                            // Jika data adalah array objek
                            if (data && typeof data[0] === 'object') {
                                return data.map(item =>
                                    item.nomor ?
                                    `${item.nomor} (${item.tipe || 'Tidak dikategorikan'})` : ''
                                ).join(', ') || 'Tidak ada nomor HP';
                            }

                            return 'Tidak ada nomor HP';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                              <a href="#" data-id="${row.id}" id="editDokter" class="btn btn-primary btn-sm">Edit</a>
                              <a href="#" data-id="${row.id}" id="deleteDokter" class="btn btn-danger btn-sm">Hapus</a>
                          `;
                        }
                    }
                ],
                order: [
                    [1, 'asc']
                ],
                columnDefs: [{
                        target: 0,
                        className: 'text-center',
                        width: '5%'
                    },
                    {
                        targets: 1,
                        className: 'text-center'
                    },
                    {
                        targets: 2,
                        className: 'text-center'
                    },
                    {
                        targets: -1,
                        className: 'text-center',
                        width: '10%'
                    },
                ],
            });

            // Tambah input nomor HP dinamis
            $(document).on('click', '.add-nomor-hp', function() {
                var newInput = `
        <div class="mb-3 input-group">
          <input type="text" class="form-control" name="nomor_hp[]"
            placeholder="Masukkan nomor HP">
          <button class="btn btn-danger remove-nomor-hp" type="button">
              <i class="fas fa-minus"></i>
          </button>
        </div>
    `;
                $('.nomor_hp_container').append(newInput);
            });

            // Hapus input nomor HP
            $(document).on('click', '.remove-nomor-hp', function() {
                $(this).closest('.mb-3').remove();
            });

            // Add Dokter Form Submission
            $('#addDokterForm').on('submit', function(e) {
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
                                text: 'Data dokter berhasil ditambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#addDokterForm')[0].reset();
                            $('.nomor_hp_container .mb-3:not(:first-child)').remove();
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

            // Delete Dokter
            $('#tableDokter').on('click', '#deleteDokter', function(e) {
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
                            url: `/panel/dokter/${id}/destroy`,
                            type: 'GET',
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data dokter berhasil dihapus',
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

            // Edit Dokter - Open Modal
            $('#tableDokter').on('click', '#editDokter', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    url: `/panel/dokter/${id}/edit`,
                    type: 'GET',
                    success: function(response) {
                        // Buat dynamic input untuk nomor HP
                        var nomorHpInputs = response.nomor_hp.map((nomor, index) => `
                <div class="mb-3 input-group">
                    <input type="text" class="form-control" name="nomor_hp[]"
                        value="${nomor}" placeholder="Masukkan nomor HP">
                    ${index > 0 ? `
                                                                <button class="btn btn-danger remove-nomor-hp-edit" type="button">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>` : ''}
                </div>
            `).join('');

                        // Create dynamic edit modal
                        var modalHtml = `
                <div class="modal fade" id="editDokterModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Dokter</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="editDokterForm">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="${response.id}">
                                    <div class="mb-3">
                                        <label for="edit_nama" class="form-label">Nama Dokter</label>
                                        <input type="text" class="form-control" id="edit_nama" name="nama" value="${response.nama}" required>
                                    </div>
                                    <div class="nomor_hp_container_edit">
                                        ${nomorHpInputs}
                                        <div class="text-right">
                                            <button class="btn btn-success add-nomor-hp-edit" type="button">
                                                <i class="fas fa-plus"></i> Tambah Nomor HP
                                            </button>
                                        </div>
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
                        $('#editDokterModal').remove();
                        $('body').append(modalHtml);

                        // Show modal
                        new bootstrap.Modal(document.getElementById('editDokterModal')).show();
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

            // Event delegation untuk tambah nomor HP di modal edit (DILUAR ajax success)
            $(document).on('click', '.add-nomor-hp-edit', function() {
                var newInput = `
        <div class="mb-3 input-group">
            <input type="text" class="form-control" name="nomor_hp[]"
                placeholder="Masukkan nomor HP">
            <button class="btn btn-danger remove-nomor-hp-edit" type="button">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    `;
                // Tambahkan input baru sebelum tombol tambah
                $(this).closest('.nomor_hp_container_edit').find('.text-right').before(newInput);
            });

            // Event delegation untuk hapus nomor HP di modal edit (DILUAR ajax success)
            $(document).on('click', '.remove-nomor-hp-edit', function() {
                $(this).closest('.mb-3').remove();
            });

            // Submit Edit Dokter Form
            $(document).on('submit', '#editDokterForm', function(e) {
                e.preventDefault();
                var id = $('input[name="id"]').val();

                $.ajax({
                    url: `/panel/dokter/${id}/update`,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data dokter berhasil diupdate',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                $('#editDokterModal').modal('hide');
                                table.ajax.reload();
                            });
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
                window.location.href = "{{ route('export.dokter') }}";
            });
        });
    </script>

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>

</html>

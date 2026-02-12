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

        #tableExtension {
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
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="{{ route('home') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Daftar Extension
                        </a>
                        <a class="nav-link" href="{{ route('daftar-memori-telepon') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Daftar Memori Telepon
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard Guest</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <hr>
                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Extension
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tableExtension" class="table table-striped table-hover table-bordered"
                                    style="width: 100%;">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Ext</th>
                                            <th>Nama</th>
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
                    url: "{{ route('home') }}",
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
                ],
                order: [
                    [1, 'asc']
                ],
                columnDefs: [{
                        targets: -1,
                        className: 'text-center',
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
        });
    </script>

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>

</html>

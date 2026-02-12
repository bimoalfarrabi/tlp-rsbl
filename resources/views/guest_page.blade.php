@extends('_Layouts.main')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-xl-12">
            <div class="card bg-primary text-white overflow-hidden border-0" style="background: linear-gradient(135deg, var(--rs-primary) 0%, var(--rs-secondary) 100%) !important; border-radius: 20px;">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Direktori Internal</span>
                            <h1 class="display-6 fw-bold mb-2">Cari Nomor Extension</h1>
                            <p class="lead opacity-75 mb-4">Temukan nomor telepon unit kerja RSUD Blambangan dengan cepat.</p>
                            
                            <div class="d-flex flex-wrap gap-2">
                                <div class="bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-3 small">
                                    <i class="fas fa-phone-alt me-2"></i> <strong>Internal:</strong> Tekan Nomor EXT
                                </div>
                                <div class="bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-3 small">
                                    <i class="fas fa-building me-2"></i> <strong>Gedung TU:</strong> Tekan 88 + EXT
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block text-center">
                            <i class="fas fa-search-plus opacity-25" style="font-size: 10rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-0">
            <div class="table-responsive p-4">
                <table id="tableExtension" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center text-muted small fw-bold text-uppercase" width="80">NO</th>
                            <th class="text-center text-muted small fw-bold text-uppercase" width="150">EXTENSION</th>
                            <th class="text-muted small fw-bold text-uppercase">NAMA RUANGAN / UNIT KERJA</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- DataTables Ajax --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        // Destroy existing table if it exists to prevent reinitialization error
        if ($.fn.DataTable.isDataTable('#tableExtension')) {
            $('#tableExtension').DataTable().destroy();
        }

        var table = $('#tableExtension').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Semua"]
            ],
            dom: "<'row mb-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "search": "",
                "searchPlaceholder": "Cari ruangan atau nomor...",
                "lengthMenu": "Tampilkan _MENU_",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "next": "<i class='fas fa-chevron-right'></i>",
                    "previous": "<i class='fas fa-chevron-left'></i>"
                }
            },
            ajax: {
                url: "{{ route('home') }}",
                type: "GET"
            },
            columns: [
                {
                    data: null,
                    className: 'text-center fw-medium text-muted',
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
                    className: 'fw-semibold'
                },
            ],
            order: [[1, 'asc']],
            responsive: true,
            drawCallback: function() {
                $('.dataTables_filter input').addClass('form-control shadow-sm border-0 bg-light px-4 py-2 rounded-pill');
                $('.dataTables_filter input').css('width', '300px');
                $('.dataTables_length select').addClass('form-select border-0 bg-light shadow-sm');
            }
        });
    });
</script>
@endpush

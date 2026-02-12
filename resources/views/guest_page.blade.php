@extends('_Layouts.main')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-xl-12">
            <div class="card bg-primary text-white overflow-hidden border-0 shadow-lg" style="background: linear-gradient(135deg, var(--rs-primary) 0%, var(--rs-secondary) 100%) !important; border-radius: 24px;">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Direktori Internal RSUD Blambangan</span>
                            <h1 class="display-5 fw-bold mb-3">Cari Nomor Extension</h1>
                            <p class="lead opacity-75 mb-4">Temukan nomor telepon unit kerja atau ruangan dengan mengetik nama atau nomor di bawah ini.</p>
                            
                            <!-- Large Search Bar -->
                            <div class="position-relative mb-4">
                                <span class="position-absolute top-50 start-0 translate-middle-y ms-4 text-primary">
                                    <i class="fas fa-search fs-4"></i>
                                </span>
                                <input type="text" id="customSearch" class="form-control form-control-lg border-0 shadow-lg py-3 rounded-4" 
                                    placeholder="Ketik Nama Ruangan atau Nomor EXT..." 
                                    style="font-size: 1.1rem; height: 65px; padding-left: 4rem;">
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <div class="bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-3 small">
                                    <i class="fas fa-phone-alt me-2"></i> <strong>Internal:</strong> Angkat Gagang - Tekan Nomor EXT
                                </div>
                                <div class="bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-3 small">
                                    <i class="fas fa-building me-2"></i> <strong>Gedung TU:</strong> Tekan 88 + EXT
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 d-none d-lg-block text-center">
                            <i class="fas fa-phone-volume opacity-25" style="font-size: 12rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive p-4">
                <table id="tableExtension" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center text-muted small fw-bold text-uppercase" width="80">NO</th>
                            <th class="text-center text-muted small fw-bold text-uppercase" width="180">EXTENSION</th>
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
        // Destroy existing table if it exists
        if ($.fn.DataTable.isDataTable('#tableExtension')) {
            $('#tableExtension').DataTable().destroy();
        }

        var table = $('#tableExtension').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            // Hide the default search box
            dom: "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-4 p-4'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
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
                    className: 'text-center fw-bold text-primary fs-5'
                },
                {
                    data: 'nama',
                    className: 'fw-semibold text-dark fs-6'
                },
            ],
            order: [[1, 'asc']],
            responsive: true
        });

        // Link custom search input to DataTable
        $('#customSearch').keyup(function(){
            table.search($(this).val()).draw() ;
        });
    });
</script>
@endpush

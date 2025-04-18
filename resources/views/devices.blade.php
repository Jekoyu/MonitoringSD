@extends('layouts.app')

@section('title', 'Daftar Perangkat Jaringan')
@section('page-title', 'Manajemen Perangkat')

@section('content')

<div class="col-lg-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">Daftar Perangkat Jaringan</h4>
            </div>
            <!-- <div class="iq-card-header-toolbar d-flex align-items-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDeviceModal">
                    <i class="ri-add-line mr-1"></i>Tambah Perangkat
                </button>
            </div> -->
        </div>
        <div class="iq-card-body">
            <div class="table-responsive">
                <table id="devices-table" class="table table-striped table-bordered mt-4" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>MAC Address</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Last Up</th>
                           
                        </tr>
                    </thead>

                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script>
    $('#devices-table').DataTable({
        ajax: {
            url: '{{ route("api.interfaces") }}', // ganti sesuai rute API kamu
            dataSrc: 'data'
        },
        columns: [{
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'name'
            },
            {
                data: 'mac-address'
            },
            {
                data: 'type'
            },
            {
                data: 'running',
                render: function(data) {
                    return data === 'true' ?
                        '<span class="badge badge-success">Online</span>' :
                        '<span class="badge badge-danger">Offline</span>';
                }
            },
            {
                data: 'last-link-up-time',
                render: function(data) {
                    return data ? data : '-';
                }
            }
        ],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari...",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data yang ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            paginate: {
                previous: "<i class='ri-arrow-left-s-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>"
            }
        }
    });
</script>
@endpush
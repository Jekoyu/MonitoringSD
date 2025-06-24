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
    $(document).ready(function () {
        $('#devices-table').DataTable({
            ajax: {
                url: 'http://206.189.41.115:5000/interfaces',
                dataSrc: function (json) {
                    if (!json || !Array.isArray(json.interfaces)) return [];

                    return json.interfaces.map((item, index) => {
                        const isOnline = item.running === 'true';

                        return {
                            name: item.name || '-',
                            mac: item['mac-address'] || '-',
                            type: item.type || '-',
                            running: item.running || 'false',
                            last_up: isOnline ? '' : (item['last-link-up-time'] || '-')
                        };
                    });
                }
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'name', title: 'Nama' },
                { data: 'mac', title: 'MAC Address' },
                { data: 'type', title: 'Tipe' },
                {
                    data: 'running',
                    title: 'Status',
                    render: function (data) {
                        return data === 'true'
                            ? '<span class="badge badge-success">Online</span>'
                            : '<span class="badge badge-danger">Offline</span>';
                    }
                },
                {
                    data: 'last_up',
                    title: 'Last Up',
                    render: function (data) {
                        return data ? data : '<span class="text-muted">-</span>';
                    }
                }
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari perangkat...",
                lengthMenu: "Tampilkan _MENU_ perangkat per halaman",
                zeroRecords: "Tidak ada perangkat ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ perangkat",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 perangkat",
                infoFiltered: "(disaring dari _MAX_ total perangkat)",
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'></i>",
                    next: "<i class='ri-arrow-right-s-line'></i>"
                }
            }
        });
    });
</script>
@endpush


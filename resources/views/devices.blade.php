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
        </div>
        <div class="iq-card-body">
            <div class="table-responsive">
                <table id="devices-table" class="table table-striped table-bordered mt-4" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>MAC Address</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Last Up</th>
                            <th>Download</th>
                            <th>Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let deviceTable = null;
    let trafficData = {};

    async function fetchAllTrafficBatch() {
        try {
            const res = await fetch('http://206.189.41.115:5000/traffic/all');
            if (!res.ok) throw new Error('Fetch traffic gagal');

            const json = await res.json(); // sesuai contoh data dari kamu
            trafficData = {}; // reset sebelumnya

            (json.traffic || []).forEach(entry => {
                const ifaceName = entry.iface;
                const stats = entry.traffic?.[0]; // ambil objek pertama dari array "traffic"
                if (ifaceName && stats) {
                    trafficData[ifaceName] = {
                        rx: (parseFloat(stats['rx-bits-per-second']) || 0) / 1_000_000,
                        tx: (parseFloat(stats['tx-bits-per-second']) || 0) / 1_000_000
                    };
                }
            });

        } catch (e) {
            console.error("Gagal memproses traffic:", e);
            trafficData = {};
        }
    }


    function updateTrafficInTable() {
        if (!deviceTable) return;
        deviceTable.rows().every(function() {
            const rowData = this.data();
            const node = this.node();
            const iface = rowData.name;

            const traffic = trafficData[iface];
            if (traffic) {
                const rx = traffic.rx.toFixed(2);
                const tx = traffic.tx.toFixed(2);
                $(node).find('td').eq(6).html(`${rx} Mbps`);
                $(node).find('td').eq(7).html(`${tx} Mbps`);
            } else {
                $(node).find('td').eq(6).html('-');
                $(node).find('td').eq(7).html('-');
            }
        });
    }


    $(document).ready(function() {
        deviceTable = $('#devices-table').DataTable({
            ajax: {
                url: 'http://206.189.41.115:5000/interfaces',
                dataSrc: function(json) {
                    if (!json || !Array.isArray(json.interfaces)) return [];
                    return json.interfaces.map(item => {
                        const isOnline = item.running === 'true';
                        return {
                            name: item.name || '-',
                            mac: item['mac-address'] || '-',
                            type: item.type || '-',
                            running: item.running || 'false',
                            last_up: isOnline ? '' : (item['last-link-up-time'] || '-'),
                            download: '-', // placeholder
                            upload: '-' // placeholder
                        };
                    });
                }
            },
            columns: [{
                    data: null,
                    render: (data, type, row, meta) => meta.row + 1
                },
                {
                    data: 'name'
                },
                {
                    data: 'mac'
                },
                {
                    data: 'type'
                },
                {
                    data: 'running',
                    render: data =>
                        data === 'true' ?
                        '<span class="badge badge-success">Online</span>' :
                        '<span class="badge badge-danger">Offline</span>'
                },
                {
                    data: 'last_up',
                    render: data => data ? data : '<span class="text-muted">-</span>'
                },
                {
                    data: 'download'
                }, // Kolom download
                {
                    data: 'upload'
                }, // Kolom upload
                {
                    data: 'name',
                    render: name => `
                        <a href="/device-details/${encodeURIComponent(name)}" class="btn btn-sm btn-outline-primary">
                            Detail
                        </a>`
                }
            ],
            responsive: true,
            initComplete: function() {
                // Mulai polling data traffic setiap 5 detik
                setInterval(async () => {
                    await fetchAllTrafficBatch();
                    updateTrafficInTable();
                }, 1000);
            },
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
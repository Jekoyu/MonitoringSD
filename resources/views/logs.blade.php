@extends('layouts.app')

@section('title', 'Log Aktivitas MikroTik')
@section('page-title', 'Log Sistem MikroTik')

@section('content')

<div id="loading-spinner" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<div class="col-lg-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">
                    <i class="ri-history-line text-primary mr-2"></i>
                    Log Aktivitas MikroTik
                </h4>
            </div>
            <button id="toggle-duplicate" class="btn btn-sm btn-outline-secondary ml-2">
                <i class="ri-filter-3-line mr-1"></i> Sembunyikan Duplikat
            </button>

            <div class="iq-card-header-toolbar d-flex align-items-center">
                <div class="dropdown">
                    <span class="dropdown-toggle dropdown-bg iq-bg-primary" id="logFilterDropdown" data-toggle="dropdown">
                        <i class="ri-filter-line mr-1"></i> Filter
                    </span>
                    <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="logFilterDropdown">
                        <a class="dropdown-item active" href="#" data-type="all">Semua Log</a>
                        <a class="dropdown-item" href="#" data-type="system">System</a>
                        <a class="dropdown-item" href="#" data-type="firewall">Firewall</a>
                        <a class="dropdown-item" href="#" data-type="interface">Interface</a>
                        <a class="dropdown-item" href="#" data-type="wireless">Wireless</a>
                    </div>
                </div>
                <button id="refresh-log" class="btn btn-sm btn-primary ml-2">
                    <i class="ri-refresh-line mr-1"></i> Refresh
                </button>
            </div>
        </div>
        <div class="iq-card-body">
            <div class="table-responsive">
                <table id="log-table" class="table table-striped table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="8%">Waktu</th>
                            <th width="12%">Tipe</th>
                            <th width="15%">Topik</th>
                            <th>Pesan</th>
                            <th width="10%">IP</th>
                            <th width="10%">User</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Log -->
<div class="modal fade" id="logDetailModal" tabindex="-1" role="dialog" aria-labelledby="logDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logDetailModalLabel">Detail Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th width="30%">Waktu</th>
                            <td id="log-time">-</td>
                        </tr>
                        <tr>
                            <th>Tipe</th>
                            <td id="log-type">-</td>
                        </tr>
                        <tr>
                            <th>Topik</th>
                            <td id="log-topic">-</td>
                        </tr>
                        <tr>
                            <th>Pesan Lengkap</th>
                            <td id="log-message">-</td>
                        </tr>
                        <tr>
                            <th>Alamat IP</th>
                            <td id="log-ip">-</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td id="log-user">-</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        var table = $('#log-table').DataTable({
            responsive: true,
            order: [
                [0, 'desc']
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            },
            ajax: {
                url: '{{ route("api.logs") }}', // Route untuk API log
                dataSrc: 'data' // Data di dalam objek "data"
            },
            columns: [{
                    data: 'time'
                },
                {
                    data: 'topics',
                    render: function(data) {
                        var mainType = data.split(',')[0].toUpperCase();
                        var badgeClass = {
                            SYSTEM: 'info',
                            FIREWALL: 'danger',
                            INTERFACE: 'warning',
                            WIRELESS: 'primary',
                            DHCP: 'secondary'
                        } [mainType] || 'dark';
                        return `<span class="badge badge-${badgeClass}">${mainType}</span>`;
                    }
                },
                {
                    data: 'topics',
                    render: function(data) {
                        return data.split(',')[1] || '-';
                    }
                },
                {
                    data: 'message'
                },
                {
                    data: 'message',
                    render: function(data) {
                        const ipMatch = data.match(/\b\d{1,3}(?:\.\d{1,3}){3}\b/);
                        return ipMatch ? ipMatch[0] : '-';
                    }
                },
                {
                    data: 'message',
                    render: function(data) {
                        const userMatch = data.match(/user\s+(\w+)/i);
                        return userMatch ? userMatch[1] : '-';
                    }
                }
            ]
        });

        // Filter log berdasarkan tipe
        $('.dropdown-item[data-type]').click(function(e) {
            e.preventDefault();
            var type = $(this).data('type');

            $('.dropdown-item').removeClass('active');
            $(this).addClass('active');

            if (type === 'all') {
                table.search('').columns().search('').draw();
            } else {
                table.columns(1).search(type).draw();
            }
        });

        let hideDuplicates = false;

        $('#toggle-duplicate').click(function() {
            hideDuplicates = !hideDuplicates;

            $(this).toggleClass('btn-outline-secondary btn-secondary');
            $(this).html(hideDuplicates ?
                '<i class="ri-filter-3-line mr-1"></i> Tampilkan Semua' :
                '<i class="ri-filter-3-line mr-1"></i> Sembunyikan Duplikat');

            filterDuplicates();
        });

        function filterDuplicates() {
            const seen = new Set();

            $('#log-table tbody tr').each(function() {
                const message = $(this).find('td').eq(3).text().trim(); // kolom message
                const time = $(this).find('td').eq(0).text().trim(); // kolom waktu
                const key = `${message}-${time}`;

                if (hideDuplicates && seen.has(key)) {
                    $(this).hide();
                } else {
                    $(this).show();
                    seen.add(key);
                }
            });
        }

        // panggil setelah data baru dimuat
        table.on('draw', function() {
            if (hideDuplicates) {
                filterDuplicates();
            }
        });

        // Tombol refresh
        $('#refresh-log').click(function() {
            $('#loading-spinner').show(); // Tampilkan spinner

            table.ajax.reload(function() {
                $('#loading-spinner').hide(); // Sembunyikan setelah selesai

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Log berhasil diperbarui',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        });


        // Detail log saat row diklik
        $('#log-table tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            $('#log-time').text(data.time);
            $('#log-type').html(data.topics);
            $('#log-topic').text(data.topics.split(',')[1] || '-');
            $('#log-message').text(data.message);

            const ipMatch = data.message.match(/\b\d{1,3}(?:\.\d{1,3}){3}\b/);
            $('#log-ip').text(ipMatch ? ipMatch[0] : '-');

            const userMatch = data.message.match(/user\s+(\w+)/i);
            $('#log-user').text(userMatch ? userMatch[1] : '-');

            $('#logDetailModal').modal('show');
        });
    });
</script>
@endpush
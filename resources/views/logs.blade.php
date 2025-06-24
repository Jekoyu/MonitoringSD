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
    $(document).ready(function () {
        const logTable = $('#log-table').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            },
            ajax: {
                url: 'http://206.189.41.115:5000/logs',
                dataSrc: function (json) {
                    if (!json || !Array.isArray(json.logs)) return [];
                    return json.logs.map(log => ({
                        time: log.time || '-',
                        topics: log.topics || '-',
                        message: log.message || '-'
                    }));
                }
            },
            columns: [
                { data: 'time', title: 'Waktu' },
                {
                    data: 'topics',
                    title: 'Tipe',
                    render: function (data) {
                        const mainType = (data || '').split(',')[0].toUpperCase();
                        const badgeClass = {
                            SYSTEM: 'info',
                            FIREWALL: 'danger',
                            INTERFACE: 'warning',
                            WIRELESS: 'primary',
                            DHCP: 'secondary'
                        }[mainType] || 'dark';
                        return `<span class="badge badge-${badgeClass}">${mainType}</span>`;
                    }
                },
                {
                    data: 'topics',
                    title: 'Topik',
                    render: function (data) {
                        const parts = (data || '').split(',');
                        return parts[1] || '-';
                    }
                },
                { data: 'message', title: 'Pesan' },
                {
                    data: 'message',
                    title: 'IP',
                    render: function (data) {
                        const ipMatch = data.match(/\b\d{1,3}(?:\.\d{1,3}){3}\b/);
                        return ipMatch ? ipMatch[0] : '-';
                    }
                },
                {
                    data: 'message',
                    title: 'User',
                    render: function (data) {
                        const userMatch = data.match(/user\s+([\w-]+)/i);
                        return userMatch ? userMatch[1] : '-';
                    }
                }
            ]
        });

        // FILTER TIPE LOG
        $('.dropdown-item[data-type]').click(function (e) {
            e.preventDefault();
            const type = $(this).data('type').toLowerCase();

            $('.dropdown-item').removeClass('active');
            $(this).addClass('active');

            if (type === 'all') {
                logTable.search('').columns().search('').draw();
            } else {
                logTable.columns(1).search(type, true, false).draw(); // search by Tipe column (badge)
            }
        });

        // SEMBUNYIKAN DUPLIKAT
        let hideDuplicates = false;

        $('#toggle-duplicate').click(function () {
            hideDuplicates = !hideDuplicates;
            $(this).toggleClass('btn-outline-secondary btn-secondary');
            $(this).html(
                hideDuplicates
                    ? '<i class="ri-filter-3-line mr-1"></i> Tampilkan Semua'
                    : '<i class="ri-filter-3-line mr-1"></i> Sembunyikan Duplikat'
            );
            filterDuplicates();
        });

        function filterDuplicates() {
            const seen = new Set();

            $('#log-table tbody tr').each(function () {
                const $row = $(this);
                const msg = $row.find('td').eq(3).text().trim(); // pesan
                const time = $row.find('td').eq(0).text().trim(); // waktu
                const key = `${msg}-${time}`;

                if (hideDuplicates && seen.has(key)) {
                    $row.hide();
                } else {
                    $row.show();
                    seen.add(key);
                }
            });
        }

        logTable.on('draw', function () {
            if (hideDuplicates) filterDuplicates();
        });

        // REFRESH LOG
        $('#refresh-log').click(function () {
            $('#loading-spinner').show();
            logTable.ajax.reload(function () {
                $('#loading-spinner').hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Log berhasil diperbarui',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        });

        // MODAL DETAIL
        $('#log-table tbody').on('click', 'tr', function () {
            const data = logTable.row(this).data();
            $('#log-time').text(data.time || '-');
            $('#log-type').text(data.topics || '-');
            $('#log-topic').text((data.topics || '').split(',')[1] || '-');
            $('#log-message').text(data.message || '-');

            const ipMatch = data.message.match(/\b\d{1,3}(?:\.\d{1,3}){3}\b/);
            $('#log-ip').text(ipMatch ? ipMatch[0] : '-');

            const userMatch = data.message.match(/user\s+([\w-]+)/i);
            $('#log-user').text(userMatch ? userMatch[1] : '-');

            $('#logDetailModal').modal('show');
        });
    });
</script>
@endpush

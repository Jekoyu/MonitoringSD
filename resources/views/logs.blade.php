@extends('layouts.app')

@section('title', 'Log Aktivitas MikroTik')
@section('page-title', 'Log Sistem MikroTik')

@section('content')

    <div class="col-lg-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">
                        <i class="ri-history-line text-primary mr-2"></i>
                        Log Aktivitas MikroTik
                    </h4>
                </div>
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
                        <tbody>
                            <!-- Log System -->
                            <tr>
                                <td>10:05:23</td>
                                <td><span class="badge badge-info">SYSTEM</span></td>
                                <td>Login</td>
                                <td>User admin logged in from 192.168.1.100 via web</td>
                                <td>192.168.1.100</td>
                                <td>admin</td>
                            </tr>
                            <tr>
                                <td>10:07:45</td>
                                <td><span class="badge badge-info">SYSTEM</span></td>
                                <td>Configuration</td>
                                <td>DHCP server modified</td>
                                <td>192.168.1.100</td>
                                <td>admin</td>
                            </tr>
                            
                            <!-- Log Firewall -->
                            <tr>
                                <td>10:15:12</td>
                                <td><span class="badge badge-danger">FIREWALL</span></td>
                                <td>Block</td>
                                <td>Blocked TCP connection from 45.125.222.10:54321 to 192.168.1.5:3389</td>
                                <td>45.125.222.10</td>
                                <td>-</td>
                            </tr>
                            
                            <!-- Log Interface -->
                            <tr>
                                <td>11:30:33</td>
                                <td><span class="badge badge-warning">INTERFACE</span></td>
                                <td>Status</td>
                                <td>ether1 link up (1Gbps full duplex)</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            
                            <!-- Log Wireless -->
                            <tr>
                                <td>12:45:18</td>
                                <td><span class="badge badge-primary">WIRELESS</span></td>
                                <td>Connection</td>
                                <td>Client 00:1A:2B:3C:4D:5E connected to SSID 'SekolahNet'</td>
                                <td>192.168.1.15</td>
                                <td>-</td>
                            </tr>
                            
                            <!-- Log System -->
                            <tr>
                                <td>13:20:05</td>
                                <td><span class="badge badge-info">SYSTEM</span></td>
                                <td>Reboot</td>
                                <td>System rebooted by admin</td>
                                <td>192.168.1.100</td>
                                <td>admin</td>
                            </tr>
                            
                            <!-- Log Firewall -->
                            <tr>
                                <td>14:10:37</td>
                                <td><span class="badge badge-danger">FIREWALL</span></td>
                                <td>Rule</td>
                                <td>Added new firewall rule (block UDP 1900)</td>
                                <td>192.168.1.100</td>
                                <td>admin</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    var table = $('#log-table').DataTable({
        responsive: true,
        order: [[0, 'desc']],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
        }
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

    // Tombol refresh
    $('#refresh-log').click(function() {
        $(this).html('<i class="ri-refresh-line mr-1"></i> Memuat...');
        setTimeout(function() {
            $('#refresh-log').html('<i class="ri-refresh-line mr-1"></i> Refresh');
            // Di sini bisa ditambahkan AJAX untuk load data terbaru
            alert('Log telah diperbarui');
        }, 1000);
    });

    // Detail log saat row diklik
    $('#log-table tbody').on('click', 'tr', function() {
        var data = table.row(this).data();
        $('#log-time').text(data[0]);
        $('#log-type').html(data[1]);
        $('#log-topic').text(data[2]);
        $('#log-message').text(data[3]);
        $('#log-ip').text(data[4]);
        $('#log-user').text(data[5]);
        $('#logDetailModal').modal('show');
    });
});
</script>
@endpush
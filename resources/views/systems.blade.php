@extends('layouts.app')

@section('title', 'Sistem MikroTik')
@section('page-title', 'Manajemen Perangkat MikroTik')

@section('content')

    <div class="col-lg-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">
                        <i class="ri-router-line text-primary mr-2"></i>
                        Daftar Perangkat MikroTik
                    </h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <button id="refresh-btn" class="btn btn-sm btn-primary">
                        <i class="ri-refresh-line mr-1"></i> Refresh
                    </button>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <table id="mikrotik-table" class="table table-striped table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Perangkat</th>
                                <th>Alamat IP</th>
                                <th>Model</th>
                                <th>Status</th>
                                <th>Uptime</th>
                                <th>CPU</th>
                                <th>Memory</th>
                                <th width="8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data Dummy -->
                            <tr>
                                <td>1</td>
                                <td>Router Utama</td>
                                <td>192.168.88.1</td>
                                <td>RB4011</td>
                                <td><span class="badge badge-success">Online</span></td>
                                <td>15d 4h 22m</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 12%"></div>
                                    </div>
                                    <small>12%</small>
                                </td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-info" style="width: 45%"></div>
                                    </div>
                                    <small>45%</small>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" title="Detail">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Switch Gedung A</td>
                                <td>192.168.88.2</td>
                                <td>CRS326</td>
                                <td><span class="badge badge-success">Online</span></td>
                                <td>8d 12h 45m</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 8%"></div>
                                    </div>
                                    <small>8%</small>
                                </td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-info" style="width: 32%"></div>
                                    </div>
                                    <small>32%</small>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" title="Detail">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>AP Ruang Guru</td>
                                <td>192.168.88.3</td>
                                <td>cAP AC</td>
                                <td><span class="badge badge-warning">Restarting</span></td>
                                <td>0d 0h 5m</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-warning" style="width: 65%"></div>
                                    </div>
                                    <small>65%</small>
                                </td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-info" style="width: 78%"></div>
                                    </div>
                                    <small>78%</small>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" title="Detail">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<!-- Modal Detail -->
<div class="modal fade" id="deviceModal" tabindex="-1" role="dialog" aria-labelledby="deviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deviceModalLabel">Detail Perangkat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                            <div class="iq-card-body">
                                <h6 class="mb-3 text-primary">Informasi Dasar</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Nama Perangkat</span>
                                        <span id="detail-name">-</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Alamat IP</span>
                                        <span id="detail-ip">-</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Model</span>
                                        <span id="detail-model">-</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Firmware</span>
                                        <span id="detail-firmware">-</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                            <div class="iq-card-body">
                                <h6 class="mb-3 text-primary">Status Sistem</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Status</span>
                                        <span id="detail-status" class="badge badge-success">-</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Uptime</span>
                                        <span id="detail-uptime">-</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>CPU Load</span>
                                        <span id="detail-cpu">-</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Memory Usage</span>
                                        <span id="detail-memory">-</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
        $('#mikrotik-table').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });

        // Tombol refresh
        $('#refresh-btn').click(function() {
            // Simulasi refresh
            $(this).html('<i class="ri-refresh-line mr-1"></i> Memuat...');
            setTimeout(function() {
                $('#refresh-btn').html('<i class="ri-refresh-line mr-1"></i> Refresh');
                alert('Data telah diperbarui');
            }, 1000);
        });

        // Tombol detail (contoh)
        $('.btn-detail').click(function() {
            var row = $(this).closest('tr');
            $('#detail-name').text(row.find('td:eq(1)').text());
            $('#detail-ip').text(row.find('td:eq(2)').text());
            $('#detail-model').text(row.find('td:eq(3)').text());
            $('#detail-status').text(row.find('td:eq(4)').text()).attr('class', row.find('td:eq(4) span').attr('class'));
            $('#detail-uptime').text(row.find('td:eq(5)').text());
            $('#detail-cpu').text(row.find('td:eq(6) small').text());
            $('#detail-memory').text(row.find('td:eq(7) small').text());
            $('#deviceModal').modal('show');
        });
    });
</script>
@endpush
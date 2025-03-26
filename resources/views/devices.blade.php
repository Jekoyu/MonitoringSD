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
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDeviceModal">
                        <i class="ri-add-line mr-1"></i>Tambah Perangkat
                    </button>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <table id="devices-table" class="table table-striped table-bordered mt-4" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Perangkat</th>
                                <th>IP Address</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Lokasi</th>
                                <th>Uptime</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Router Utama</td>
                                <td>192.168.1.1</td>
                                <td><span class="badge badge-info">Router</span></td>
                                <td><span class="badge badge-success">Online</span></td>
                                <td>Server Room</td>
                                <td>15 hari 4 jam</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-warning mr-1" data-toggle="tooltip" title="Edit"><i class="ri-pencil-line"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="ri-delete-bin-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Switch Lab Komputer</td>
                                <td>192.168.1.2</td>
                                <td><span class="badge badge-primary">Switch</span></td>
                                <td><span class="badge badge-success">Online</span></td>
                                <td>Lab Komputer 1</td>
                                <td>10 hari 2 jam</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-warning mr-1" data-toggle="tooltip" title="Edit"><i class="ri-pencil-line"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="ri-delete-bin-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>AP Perpustakaan</td>
                                <td>192.168.1.3</td>
                                <td><span class="badge badge-secondary">Access Point</span></td>
                                <td><span class="badge badge-danger">Offline</span></td>
                                <td>Perpustakaan</td>
                                <td>-</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-warning mr-1" data-toggle="tooltip" title="Edit"><i class="ri-pencil-line"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="ri-delete-bin-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>AP Ruang Guru</td>
                                <td>192.168.1.4</td>
                                <td><span class="badge badge-secondary">Access Point</span></td>
                                <td><span class="badge badge-success">Online</span></td>
                                <td>Ruang Guru</td>
                                <td>7 hari 12 jam</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-warning mr-1" data-toggle="tooltip" title="Edit"><i class="ri-pencil-line"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="ri-delete-bin-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Server Utama</td>
                                <td>192.168.1.5</td>
                                <td><span class="badge badge-dark">Server</span></td>
                                <td><span class="badge badge-success">Online</span></td>
                                <td>Server Room</td>
                                <td>30 hari 6 jam</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-warning mr-1" data-toggle="tooltip" title="Edit"><i class="ri-pencil-line"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="ri-delete-bin-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<!-- Modal Tambah Perangkat -->
<div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeviceModalLabel">Tambah Perangkat Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="deviceName">Nama Perangkat</label>
                        <input type="text" class="form-control" id="deviceName" placeholder="Contoh: Router Utama">
                    </div>
                    <div class="form-group">
                        <label for="ipAddress">IP Address</label>
                        <input type="text" class="form-control" id="ipAddress" placeholder="Contoh: 192.168.1.1">
                    </div>
                    <div class="form-group">
                        <label for="deviceType">Jenis Perangkat</label>
                        <select class="form-control" id="deviceType">
                            <option value="router">Router</option>
                            <option value="switch">Switch</option>
                            <option value="accesspoint">Access Point</option>
                            <option value="server">Server</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deviceLocation">Lokasi</label>
                        <input type="text" class="form-control" id="deviceLocation" placeholder="Contoh: Ruang Server">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Make sure jQuery is loaded first
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#devices-table').DataTable({
                responsive: true,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        } else {
            console.error('DataTables plugin is not loaded');
        }
    });
</script>
@endpush
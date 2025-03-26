@extends('layouts.app')

@section('title', 'Speed Test Jaringan')
@section('page-title', 'Tes Kecepatan Jaringan')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height iq-bg-primary">
            <div class="iq-card-body box iq-box-relative">
                <div class="box-image float-right">
                    <i class="ri-dashboard-3-line fa-4x text-white opacity-25"></i>
                </div>
                <h4 class="d-block mb-3 text-white">Speed Test Jaringan</h4>
                <p class="d-inline-block welcome-text text-white">
                    <i class="ri-information-line mr-2 text-warning"></i> 
                    Ukur kecepatan download, upload, dan latency jaringan Anda
                </p>
                <div class="d-flex flex-wrap mt-3">
                    <div class="mr-3 mb-2">
                        <span class="badge iq-bg-warning text-white">
                            <i class="ri-download-line mr-1"></i> Download: - 
                        </span>
                    </div>
                    <div class="mr-3 mb-2">
                        <span class="badge iq-bg-success text-white">
                            <i class="ri-upload-line mr-1"></i> Upload: -
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="badge iq-bg-info text-white">
                            <i class="ri-timer-line mr-1"></i> Ping: -
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <ul class="suggestions-lists m-0 p-0">
                    <li class="d-flex mb-4 align-items-center justify-content-between">
                        <div class="col-sm-9 p-0">
                            <div class="d-flex align-items-center">
                                <div class="avatar-55 text-center rounded iq-bg-primary">
                                    <i class="ri-server-line"></i>
                                </div>
                                <div class="media-support-info ml-3">
                                    <h5>Server Terdekat</h5>
                                    <p class="mb-0">Jakarta, Indonesia</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 p-0">
                            <span class="badge badge-primary">25 km</span>
                        </div>
                    </li>
                    <li class="d-flex align-items-center justify-content-between">
                        <div class="col-sm-9 p-0">
                            <div class="d-flex align-items-center">
                                <div class="avatar-55 text-center rounded iq-bg-success">
                                    <i class="ri-history-line"></i>
                                </div>
                                <div class="media-support-info ml-3">
                                    <h5>Test Terakhir</h5>
                                    <p class="mb-0">Belum ada data</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 p-0">
                            <button class="btn btn-sm btn-link p-0 text-primary">Lihat</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Tes Kecepatan</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <div class="dropdown">
                        <span class="dropdown-toggle dropdown-bg iq-bg-primary" id="serverDropdown" data-toggle="dropdown">
                            <i class="ri-server-line mr-1"></i> Pilih Server
                        </span>
                        <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="serverDropdown">
                            <a class="dropdown-item active" href="#" data-server="jakarta">Jakarta</a>
                            <a class="dropdown-item" href="#" data-server="bandung">Bandung</a>
                            <a class="dropdown-item" href="#" data-server="surabaya">Surabaya</a>
                            <a class="dropdown-item" href="#" data-server="singapore">Singapore</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="text-center py-5">
                    <div id="speedtest-container" class="mb-4">
                        <div class="speedtest-gauge" id="download-gauge">
                            <div class="gauge-header">
                                <i class="ri-download-line"></i> Download
                            </div>
                            <div class="gauge-body">
                                <div class="gauge-fill" style="height: 0%"></div>
                            </div>
                            <div class="gauge-footer">
                                <span class="speed-value">0</span> Mbps
                            </div>
                        </div>
                        
                        <div class="speedtest-gauge" id="upload-gauge">
                            <div class="gauge-header">
                                <i class="ri-upload-line"></i> Upload
                            </div>
                            <div class="gauge-body">
                                <div class="gauge-fill" style="height: 0%"></div>
                            </div>
                            <div class="gauge-footer">
                                <span class="speed-value">0</span> Mbps
                            </div>
                        </div>
                        
                        <div class="speedtest-gauge" id="ping-gauge">
                            <div class="gauge-header">
                                <i class="ri-timer-line"></i> Ping
                            </div>
                            <div class="gauge-body">
                                <div class="gauge-fill" style="height: 100%"></div>
                            </div>
                            <div class="gauge-footer">
                                <span class="speed-value">-</span> ms
                            </div>
                        </div>
                    </div>
                    
                    <button id="start-test" class="btn btn-primary btn-lg">
                        <i class="ri-play-line mr-2"></i> Mulai Tes Kecepatan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Riwayat Speed Test</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <button class="btn btn-sm btn-primary">
                        <i class="ri-download-line mr-1"></i> Ekspor Data
                    </button>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="15%">Waktu</th>
                                <th width="15%">Server</th>
                                <th>Download (Mbps)</th>
                                <th>Upload (Mbps)</th>
                                <th>Ping (ms)</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data riwayat</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #speedtest-container {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .speedtest-gauge {
        width: 150px;
        text-align: center;
    }
    
    .gauge-header {
        font-size: 16px;
        margin-bottom: 10px;
        color: #6c757d;
    }
    
    .gauge-header i {
        margin-right: 5px;
    }
    
    .gauge-body {
        height: 200px;
        width: 100%;
        background: #f8f9fa;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
    }
    
    .gauge-fill {
        position: absolute;
        bottom: 0;
        width: 100%;
        transition: height 0.5s ease-out;
    }
    
    #download-gauge .gauge-fill {
        background: linear-gradient(to top, #4eacfe, #3a7bd5);
    }
    
    #upload-gauge .gauge-fill {
        background: linear-gradient(to top, #00d2ff, #3a7bd5);
    }
    
    #ping-gauge .gauge-fill {
        background: linear-gradient(to top, #a8ff78, #78ffd6);
    }
    
    .gauge-footer {
        margin-top: 10px;
        font-size: 18px;
        font-weight: bold;
    }
    
    .gauge-footer .speed-value {
        font-size: 24px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Pilih server
    $('.dropdown-item[data-server]').click(function(e) {
        e.preventDefault();
        var server = $(this).data('server');
        var serverName = $(this).text();
        
        $('.dropdown-item').removeClass('active');
        $(this).addClass('active');
        
        $('.media-support-info p').eq(0).text(serverName);
    });

    // Simulasi speed test
    $('#start-test').click(function() {
        var $btn = $(this);
        var downloadSpeed = 0;
        var uploadSpeed = 0;
        var ping = 0;
        
        // Disable button selama test
        $btn.prop('disabled', true).html('<i class="ri-loader-4-line mr-2 animate-spin"></i> Sedang menguji...');
        
        // Reset gauge
        $('.gauge-fill').css('height', '0%');
        $('.speed-value').text('0');
        $('#ping-gauge .gauge-fill').css('height', '100%');
        
        // Update header badge
        $('.welcome-text + div span').eq(0).html('<i class="ri-download-line mr-1"></i> Download: -');
        $('.welcome-text + div span').eq(1).html('<i class="ri-upload-line mr-1"></i> Upload: -');
        $('.welcome-text + div span').eq(2).html('<i class="ri-timer-line mr-1"></i> Ping: -');
        
        // Simulasi ping test
        setTimeout(function() {
            ping = Math.floor(Math.random() * 30) + 5;
            $('#ping-gauge .speed-value').text(ping);
            $('.welcome-text + div span').eq(2).html('<i class="ri-timer-line mr-1"></i> Ping: ' + ping + 'ms');
        }, 1000);
        
        // Simulasi download test
        var downloadInterval = setInterval(function() {
            if (downloadSpeed < 95) {
                downloadSpeed += Math.floor(Math.random() * 10) + 5;
                if (downloadSpeed > 95) downloadSpeed = 95;
                
                $('#download-gauge .gauge-fill').css('height', downloadSpeed + '%');
                $('#download-gauge .speed-value').text(downloadSpeed);
            } else {
                clearInterval(downloadInterval);
            }
        }, 100);
        
        // Simulasi upload test (dimulai setelah download selesai)
        setTimeout(function() {
            var uploadInterval = setInterval(function() {
                if (uploadSpeed < 80) {
                    uploadSpeed += Math.floor(Math.random() * 8) + 3;
                    if (uploadSpeed > 80) uploadSpeed = 80;
                    
                    $('#upload-gauge .gauge-fill').css('height', uploadSpeed + '%');
                    $('#upload-gauge .speed-value').text(uploadSpeed);
                } else {
                    clearInterval(uploadInterval);
                    
                    // Update header badge dengan hasil final
                    $('.welcome-text + div span').eq(0).html('<i class="ri-download-line mr-1"></i> Download: ' + downloadSpeed + 'Mbps');
                    $('.welcome-text + div span').eq(1).html('<i class="ri-upload-line mr-1"></i> Upload: ' + uploadSpeed + 'Mbps');
                    
                    // Enable button kembali
                    setTimeout(function() {
                        $btn.prop('disabled', false).html('<i class="ri-play-line mr-2"></i> Mulai Tes Kecepatan');
                        
                        // Tambahkan ke riwayat
                        addToHistory(downloadSpeed, uploadSpeed, ping);
                    }, 500);
                }
            }, 100);
        }, 2000);
    });
    
    function addToHistory(download, upload, ping) {
        var server = $('.dropdown-item.active').text();
        var now = new Date();
        var timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                         now.getMinutes().toString().padStart(2, '0') + ':' + 
                         now.getSeconds().toString().padStart(2, '0');
        
        // Update tabel riwayat
        $('table tbody').html(`
            <tr>
                <td>${timeString}</td>
                <td>${server}</td>
                <td>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: ${download}%"></div>
                    </div>
                    <small>${download} Mbps</small>
                </td>
                <td>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: ${upload}%"></div>
                    </div>
                    <small>${upload} Mbps</small>
                </td>
                <td>
                    <span class="badge ${ping < 20 ? 'badge-success' : ping < 50 ? 'badge-warning' : 'badge-danger'}">
                        ${ping} ms
                    </span>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary">
                        <i class="ri-share-line"></i>
                    </button>
                </td>
            </tr>
        `);
        
        // Update card test terakhir
        $('.media-support-info p').eq(1).text(timeString + ' - ' + download + 'Mbps/' + upload + 'Mbps');
    }
});
</script>
@endpush
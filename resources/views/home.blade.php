@extends('layouts.app')

@section('title', 'Dashboard Monitoring Jaringan')
@section('page-title', 'Dashboard Jaringan SD')

@section('content')
<div class="col-lg-8">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height iq-bg-primary">
        <div class="iq-card-body box iq-box-relative">
            <div class="box-image float-right">
                <img class="rounded img-fluid" src="{{ asset('assets/images/page-img/37.png') }}" alt="network">
            </div>
            <h4 class="d-block mb-3 ">Monitoring Jaringan
                SD Negeri Banguntapan</h4>
            <p class="d-inline-block welcome-text ">
                <i class="ri-information-line mr-2 text-warning"></i>
                Sistem pemantauan jaringan sekolah dasar. Pantau status koneksi, bandwidth, dan perangkat jaringan.
            </p>
            <div class="d-flex flex-wrap mt-3">
                <div class="mr-3 mb-2">
                    <span class="badge iq-bg-warning" id="onlineCount">
                        <i class="ri-wifi-line mr-1"></i> ... Perangkat Online
                    </span>
                </div>
                <div class="mr-3 mb-2">
                    <span class="badge iq-bg-danger" id="offlineCount">
                        <i class="ri-alarm-warning-line mr-1"></i> ... Gangguan
                    </span>
                </div>
                <div class="mb-2">
                    <span class="badge iq-bg-success ">
                        <i class="ri-shield-check-line mr-1"></i> Keamanan Aktif
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
                                <i class="ri-computer-line"></i>
                            </div>
                            <div class="media-support-info ml-3">
                                <h5>Perangkat Aktif</h5>
                                <p class="mb-0" id="deviceOnlineText">0 Terhubung</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 p-0">
                        <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                            <div class="iq-progress-bar">
                                <span class="bg-primary" id="deviceOnlineBar" data-percent="0"></span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="d-flex align-items-center justify-content-between">
                    <div class="col-sm-9 p-0">
                        <div class="d-flex align-items-center">
                            <div class="avatar-55 text-center rounded iq-bg-danger">
                                <i class="ri-alert-line"></i>
                            </div>
                            <div class="media-support-info ml-3">
                                <h5>Gangguan</h5>
                                <p class="mb-0" id="deviceOfflineText">0 Perangkat Offline</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 p-0">
                        <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                            <div class="iq-progress-bar">
                                <span class="bg-danger" id="deviceOfflineBar" data-percent="0"></span>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="col-lg-8 row m-0 p-0">
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="icon iq-icon-box iq-bg-primary rounded" data-wow-delay="0.2s">
                    <i class="ri-download-line"></i>
                </div>
                <div class="mt-4">
                    <h5 class="text-black text-uppercase">Download</h5>
                    <h3 class="d-flex text-primary"> <?= $ether2['rx-byte'] ?><i class="ri-arrow-up-line"></i></h3>
                </div>

                <div class="mt-3">
                    <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                        <div class="iq-progress-bar">
                            <span class="bg-primary" data-percent="<?= $ether2['rx-byte'] ?>"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="icon iq-icon-box iq-bg-danger rounded" data-wow-delay="0.2s">
                    <i class="ri-upload-line"></i>
                </div>
                <div class="mt-4">
                    <h5 class="text-black text-uppercase">Upload</h5>
                    <h3 class="d-flex text-danger"> <?= $ether2['tx-byte'] ?><i class="ri-arrow-up-line"></i></h3>
                </div>

                <div class="mt-3">
                    <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                        <div class="iq-progress-bar">
                            <span class="bg-danger" data-percent="<?= $ether2['tx-byte'] ?>"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="icon iq-icon-box iq-bg-success rounded" data-wow-delay="0.2s">
                    <i class="ri-wifi-line"></i>
                </div>
                <div class="mt-4">
                    <h5 class="text-black text-uppercase">Uptime</h5>
                    <h3 class="d-flex text-success"> <?= $uptime ?></h3>
                </div>

                <div class="mt-3">
                    <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                        <div class="iq-progress-bar">
                            <span class="bg-success" data-percent="99"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="icon iq-icon-box iq-bg-warning rounded" data-wow-delay="0.2s">
                    <i class="ri-time-line"></i>
                </div>
                <div class="mt-4">
                    <h5 class="text-black text-uppercase">Latency</h5>
                    <h3 class="d-flex text-warning"> <?= $ether2['latency'] ?>ms<i class="ri-arrow-down-line"></i></h3>
                </div>

                <div class="mt-3">
                    <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                        <div class="iq-progress-bar">
                            <span class="bg-warning" data-percent="72"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-8">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">Traffic Jaringan</h4>
            </div>
            <div class="iq-card-header-toolbar d-flex align-items-center">
                <div class="dropdown">
                    <span class="dropdown-toggle dropdown-bg iq-bg-primary" id="dropdownMenuButton1" data-toggle="dropdown">
                        Hari Ini<i class="ri-arrow-down-s-line ml-1 text-primary"></i>
                    </span>
                    <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton1">
                        <a class="dropdown-item" href="#"><i class="ri-time-line mr-2"></i>Hari Ini</a>
                        <a class="dropdown-item" href="#"><i class="ri-calendar-2-line mr-2"></i>Minggu Ini</a>
                        <a class="dropdown-item" href="#"><i class="ri-calendar-line mr-2"></i>Bulan Ini</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-card-body">
            <!-- <div id="report-chart-02" ></div> -->
            <div id="report-chart-3"></div>
        </div>
    </div>
</div>

<!-- <div class="col-lg-4">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height bg-danger rounded">
        <div class="iq-card-body">
            <div class="d-flex align-items-center mb-3">
                <div><i class="ri-alarm-warning-line fa-3x text-white"></i></div>
                <h5 class="pl-3 text-white">Peringatan Jaringan</h5>
            </div>
            <p class="mb-2"><span class="text-white">1</span> Access Point Offline</p>
            <p class="mb-2"><span class="text-white">3</span> Perangkat High Latency</p>
            <p class="mb-3"><span class="text-white">85%</span> Penggunaan Bandwidth</p>
            <button type="submit" class="btn w-100 btn-white mt-4 text-danger">Detail Masalah</button>
        </div>
    </div>
</div> -->

<div class="col-lg-6">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">Perangkat Jaringan</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <div class="">
                <table id="devices-table" class="table mb-0 table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Perangkat</th>
                            <th scope="col">Status</th>
                            <th scope="col">Mac Address</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
    <div class="iq-card-header d-flex justify-content-between">
        <div class="iq-header-title">
            <h4 class="card-title">Penggunaan Bandwidth</h4>
        </div>
        <div class="iq-card-header-toolbar d-flex align-items-center">
            <div class="dropdown">
                <button class="dropdown-toggle dropdown-bg iq-bg-primary" id="bandwidthFilterBtn" data-toggle="dropdown">
                    Hari Ini<i class="ri-arrow-down-s-line ml-1 text-primary"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="bandwidthFilterBtn">
                    <a class="dropdown-item filter-bandwidth" data-range="daily" href="#">Hari Ini</a>
                    <a class="dropdown-item filter-bandwidth" data-range="weekly" href="#">Minggu Ini</a>
                    <a class="dropdown-item filter-bandwidth" data-range="monthly" href="#">Bulan Ini</a>
                </div>
            </div>
        </div>
    </div>
    <div class="iq-card-body">
        <div id="iq-bandwidth-chart" style="min-height: 300px;"></div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    function updateDeviceSummary(data) {
        const maxDevices = 5; 
        const onlineCount = data.filter(item => item.running === "true").length;
        const offlineCount = data.filter(item => item.running !== "true").length;
        document.getElementById("onlineCount").innerHTML =
            `<i class="ri-wifi-line mr-1"></i> ${onlineCount} Perangkat Online`;

        document.getElementById("offlineCount").innerHTML =
            `<i class="ri-alarm-warning-line mr-1"></i> ${offlineCount} Gangguan`;

        document.getElementById("deviceOnlineText").innerText = `${onlineCount} Terhubung`;
        document.getElementById("deviceOfflineText").innerText = `${offlineCount} Perangkat Offline`;
        const onlinePercent = Math.round((onlineCount / maxDevices) * 100);
        const offlinePercent = 100 - onlinePercent;

        document.getElementById("deviceOnlineBar").style.width = onlinePercent + "%";
        document.getElementById("deviceOnlineBar").setAttribute("data-percent", onlinePercent);

        document.getElementById("deviceOfflineBar").style.width = offlinePercent + "%";
        document.getElementById("deviceOfflineBar").setAttribute("data-percent", offlinePercent);
    }


    $('#devices-table').DataTable({
        ajax: {
            url: '{{ route("api.interfaces") }}',
            dataSrc: function(json) {
                updateDeviceSummary(json.data);
                return json.data;
            }
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
                data: 'running',
                render: function(data) {
                    return data === 'true' ?
                        '<span class="badge badge-success">Online</span>' :
                        '<span class="badge badge-danger">Offline</span>';
                }
            },
            {
                data: 'mac-address'
            },

        ],
        responsive: true,

    });
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {


        const trafficData = {
            daily: [22, 28, 26, 35, 40, 45, 38],
            weekly: [150, 160, 175, 170, 165, 180, 190],
            monthly: [550, 600, 650, 580, 720, 700, 750]
        };

        const bandwidthData = {
            daily: {
                download: [8, 10, 9.5, 11, 10.8, 12, 11.5],
                upload: [3, 4, 3.5, 4.2, 4.1, 5, 4.5]
            },
            weekly: {
                download: [70, 75, 78, 80, 85, 82, 90],
                upload: [30, 32, 28, 34, 31, 36, 33]
            },
            monthly: {
                download: [250, 270, 260, 300, 310, 280, 290],
                upload: [110, 120, 115, 125, 130, 118, 123]
            }
        };

        // =========================
        // TRAFFIC CHART
        // =========================
        const trafficChart = new ApexCharts(document.querySelector("#report-chart-3"), {
            chart: {
                type: 'area',
                height: 200,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Traffic (MB)',
                data: trafficData.daily
            }],
            xaxis: {
                categories: ['07:00', '09:00', '11:00', '13:00', '15:00', '17:00', '19:00']
            },
            colors: ['#3b76ef'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 100]
                }
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                y: {
                    formatter: val => val + " MB"
                }
            }
        });
        trafficChart.render();

        document.querySelectorAll('.filter-traffic').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const range = this.dataset.range;
                trafficChart.updateSeries([{
                    name: 'Traffic (MB)',
                    data: trafficData[range]
                }]);
                document.getElementById('trafficFilterBtn').innerHTML = this.innerText + '<i class="ri-arrow-down-s-line ml-1 text-primary"></i>';
            });
        });

        // =========================
        // BANDWIDTH CHART
        // =========================
        const bandwidthChart = new ApexCharts(document.querySelector("#iq-bandwidth-chart"), {
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            series: [{
                    name: 'Download',
                    data: bandwidthData.daily.download
                },
                {
                    name: 'Upload',
                    data: bandwidthData.daily.upload
                }
            ],
            xaxis: {
                categories: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
            },
            colors: ['#0ac074', '#ff5c75'],
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '50%'
                }
            },
            fill: {
                opacity: 1
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                y: {
                    formatter: val => val + " Mbps"
                }
            }
        });
        bandwidthChart.render();

        document.querySelectorAll('.filter-bandwidth').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const range = this.dataset.range;
                bandwidthChart.updateSeries([{
                        name: 'Download',
                        data: bandwidthData[range].download
                    },
                    {
                        name: 'Upload',
                        data: bandwidthData[range].upload
                    }
                ]);
                document.getElementById('bandwidthFilterBtn').innerHTML = this.innerText + '<i class="ri-arrow-down-s-line ml-1 text-primary"></i>';
            });
        });

    });
</script>

@endpush
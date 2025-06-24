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

<div class="col-lg-12 row m-0 p-0">
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="icon iq-icon-box iq-bg-primary rounded" data-wow-delay="0.2s">
                    <i class="ri-download-line"></i>
                </div>
                <div class="mt-4">
                    <h5 class="text-black text-uppercase">Download</h5>
                    <h3 class="d-flex text-primary" id="downloadValue">0 Mbps<i class="ri-arrow-down-line"></i></h3>
                </div>

                <div class="mt-3">
                    <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                        <div class="iq-progress-bar">
                            <span class="bg-primary" id="downloadBar" data-percent="0"></span>
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
                    <h3 class="d-flex text-danger" id="uploadValue">0 Mbps<i class="ri-arrow-up-line"></i></h3>
                </div>

                <div class="mt-3">
                    <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                        <div class="iq-progress-bar">
                            <span class="bg-danger" id="uploadBar" data-percent="0"></span>
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
                    <h3 class="d-flex text-success" id="uptimeValue">0h0m0s</h3>

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
                <div class="icon iq-icon-box iq-bg-warning rounded">
                    <i class="ri-time-line"></i>
                </div>
                <div class="mt-4">
                    <h5 class="text-black text-uppercase">Latency</h5>
                    <h3 class="d-flex text-warning" id="latencyValue">0 ms</h3>
                </div>

                <div class="mt-3">
                    <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                        <div class="iq-progress-bar">
                            <span class="bg-warning" id="latencyBar" data-percent="0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="col-lg-12">
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


<div class="col-lg-12">
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
<div class="col-lg-12">
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
</div>

@endsection
@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let uptimeSeconds = 0;

        function parseLatencyString(str) {
            const msMatch = str.match(/(\d+)ms/);
            const usMatch = str.match(/(\d+)us/);
            const ms = parseInt(msMatch?.[1] || 0);
            const us = parseInt(usMatch?.[1] || 0);
            return (ms + us / 1000).toFixed(2);
        }

        // 2. Baru kemudian fetchLatency
        async function fetchLatency() {
            try {
                const res = await fetch('http://206.189.41.115:5000/ping/8.8.8.8');
                if (!res.ok) throw new Error('Network error');

                const data = await res.json();
                const avgRtt = data.result?.[0]?.['avg-rtt'] || '0ms';

                const latencyMs = parseLatencyString(avgRtt);

                document.getElementById('latencyValue').innerText = `${latencyMs} ms`;

                let percent = Math.max(0, 100 - latencyMs / 2);
                percent = Math.min(percent, 100);

                const latencyBar = document.getElementById('latencyBar');
                latencyBar.style.width = `${percent}%`;
                latencyBar.setAttribute('data-percent', latencyMs);
            } catch (e) {
                console.error('Gagal fetch latency:', e);
            }
        }


        async function fetchUptime() {
            try {
                const res = await fetch('http://206.189.41.115:5000/system');
                if (!res.ok) throw new Error('Network error');

                const data = await res.json();
                const uptimeStr = data.system?.[0]?.uptime || '0m';

                uptimeSeconds = parseUptimeToSeconds(uptimeStr);
                updateUptimeDisplay();
            } catch (e) {
                console.error('Gagal fetch uptime:', e);
                document.querySelector('#uptimeValue').innerText = 'Error';
            }
        }

        function parseUptimeToSeconds(str) {
            const d = parseInt(str.match(/(\d+)d/)?.[1] || 0);
            const h = parseInt(str.match(/(\d+)h/)?.[1] || 0);
            const m = parseInt(str.match(/(\d+)m/)?.[1] || 0);
            return d * 86400 + h * 3600 + m * 60;
        }

        function updateUptimeDisplay() {
            uptimeSeconds++;
            const d = Math.floor(uptimeSeconds / 86400);
            const h = Math.floor((uptimeSeconds % 86400) / 3600);
            const m = Math.floor((uptimeSeconds % 3600) / 60);
            const s = uptimeSeconds % 60;

            document.querySelector('#uptimeValue').innerText = `${d}d${h}h${m}m${s}s`;
        }

        async function fetchRealtimeTraffic() {
            try {
                const res = await fetch('http://206.189.41.115:5000/traffic/ether1');
                if (!res.ok) throw new Error('Network error');

                const data = await res.json();
                const traffic = Array.isArray(data.traffic) ? data.traffic[0] : null;

                if (!traffic) return;

                const rx_bps = parseFloat(traffic['rx-bits-per-second'] || 0);
                const tx_bps = parseFloat(traffic['tx-bits-per-second'] || 0);

                const rx_mbps = (rx_bps / 1_000_000).toFixed(2);
                const tx_mbps = (tx_bps / 1_000_000).toFixed(2);

                document.getElementById('downloadValue').innerText = `${rx_mbps} Mbps`;
                document.getElementById('uploadValue').innerText = `${tx_mbps} Mbps`;

                const rxNum = +rx_mbps,
                    txNum = +tx_mbps;

                document.getElementById('downloadBar').style.width = `${Math.min(rxNum * 10, 100)}%`;
                document.getElementById('uploadBar').style.width = `${Math.min(txNum * 10, 100)}%`;

                document.getElementById('downloadBar').setAttribute('data-percent', rx_mbps);
                document.getElementById('uploadBar').setAttribute('data-percent', tx_mbps);
            } catch (e) {
                console.error('Gagal fetch data realtime:', e);
            }
        }

        // Jalankan pertama kali
        fetchLatency();
        fetchUptime();
        fetchRealtimeTraffic();

        // Set interval
        setInterval(fetchLatency, 1000);
        setInterval(updateUptimeDisplay, 1000);
        setInterval(fetchRealtimeTraffic, 1000);
    });


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
            url: 'http://206.189.41.115:5000/interfaces',
            dataSrc: function(json) {
                const data = json.interfaces || [];
                updateDeviceSummary(data);
                return data;
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
            }
        ],
        responsive: true
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let trafficChart, bandwidthChart;

        // Ambil data trafik bandwidth langsung dari endpoint Mikrotik backend
        async function fetchBandwidthData() {
            try {
                const res = await fetch('http://206.189.41.115:5000/traffic/graph');
                if (!res.ok) throw new Error("HTTP Error");

                const data = await res.json();
                return {
                    categories: data.categories || [],
                    download: data.download || [],
                    upload: data.upload || []
                };
            } catch (e) {
                console.error("Gagal fetch bandwidth:", e);
                return {
                    categories: [],
                    download: [],
                    upload: []
                };
            }
        }

        // Inisialisasi dan render grafik
        async function initCharts() {
            const data = await fetchBandwidthData();

            // Grafik traffic (area)
            trafficChart = new ApexCharts(document.querySelector("#report-chart-3"), {
                chart: {
                    type: 'area',
                    height: 200,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                        name: 'Download',
                        data: data.download
                    },
                    {
                        name: 'Upload',
                        data: data.upload
                    }
                ],
                xaxis: {
                    categories: data.categories
                },
                colors: ['#3b76ef', '#f06548'],
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
                    width: 2
                },
                dataLabels: {
                    enabled: false
                },
                tooltip: {
                    y: {
                        formatter: val => `${val} Mbps`
                    }
                }
            });
            trafficChart.render();

            // Grafik bandwidth (bar)
            bandwidthChart = new ApexCharts(document.querySelector("#iq-bandwidth-chart"), {
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                        name: 'Download',
                        data: data.download
                    },
                    {
                        name: 'Upload',
                        data: data.upload
                    }
                ],
                xaxis: {
                    categories: data.categories
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
                        formatter: val => `${val} Mbps`
                    }
                }
            });
            bandwidthChart.render();
        }

        initCharts();
    });
</script>

@endpush
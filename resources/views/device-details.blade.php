@extends('layouts.app')

@section('title', 'Statistik Perangkat')
@section('page-title', 'Statistik Perangkat Jaringan')

@section('content')
<div class="col-lg-12">
    <div class="row">
        <!-- Kartu Download -->
        <div class="col-md-3 mb-3">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                <div class="iq-card-body text-center">
                    <div class="icon iq-icon-box iq-bg-primary rounded mb-2">
                        <i class="ri-download-line"></i>
                    </div>
                    <h6>Download</h6>
                    <h5 id="downloadValue">0 Mbps</h5>
                </div>
            </div>
        </div>
        <!-- Kartu Upload -->
        <div class="col-md-3 mb-3">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                <div class="iq-card-body text-center">
                    <div class="icon iq-icon-box iq-bg-danger rounded mb-2">
                        <i class="ri-upload-line"></i>
                    </div>
                    <h6>Upload</h6>
                    <h5 id="uploadValue">0 Mbps</h5>
                </div>
            </div>
        </div>
        <!-- Kartu Uptime -->
        <div class="col-md-3 mb-3">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                <div class="iq-card-body text-center">
                    <div class="icon iq-icon-box iq-bg-success rounded mb-2">
                        <i class="ri-wifi-line"></i>
                    </div>
                    <h6>Uptime</h6>
                    <h5 id="uptimeValue">0d0h0m0s</h5>
                </div>
            </div>
        </div>
        <!-- Kartu Latency -->
        <div class="col-md-3 mb-3">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                <div class="iq-card-body text-center">
                    <div class="icon iq-icon-box iq-bg-warning rounded mb-2">
                        <i class="ri-time-line"></i>
                    </div>
                    <h6>Latency</h6>
                    <h5 id="latencyValue">0 ms</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">
                    <i class="ri-bar-chart-line text-primary mr-2"></i>
                    Statistik Traffic: <span id="deviceName"></span>
                </h4>
            </div>
        </div>
        <div class="iq-card-body">
            <div id="traffic-chart" style="height: 350px;"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const iface = @json($device);
    document.getElementById("deviceName").innerText = iface;
    let uptimeSeconds = 0;

    function parseLatencyString(str) {
        const ms = parseInt((str.match(/(\d+)ms/) || [])[1] || 0);
        const us = parseInt((str.match(/(\d+)us/) || [])[1] || 0);
        return (ms + us / 1000).toFixed(2);
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
        document.getElementById("uptimeValue").innerText = `${d}d${h}h${m}m${s}s`;
    }

    async function fetchRealtimeStats() {
        try {
            const res = await fetch(`http://206.189.41.115:5000/traffic/${encodeURIComponent(iface)}`);
            if (!res.ok) throw new Error("Gagal ambil data");

            const data = await res.json();
            const traffic = Array.isArray(data.traffic) ? data.traffic[0] : null;
            if (!traffic) return;

            const rx = (parseFloat(traffic['rx-bits-per-second'] || 0) / 1_000_000).toFixed(2);
            const tx = (parseFloat(traffic['tx-bits-per-second'] || 0) / 1_000_000).toFixed(2);

            document.getElementById("downloadValue").innerText = `${rx} Mbps`;
            document.getElementById("uploadValue").innerText = `${tx} Mbps`;
        } catch (e) {
            console.error("Realtime error:", e);
        }
    }

    async function fetchUptime() {
        try {
            const res = await fetch("http://206.189.41.115:5000/system");
            if (!res.ok) throw new Error("Gagal fetch uptime");
            const data = await res.json();
            const uptimeStr = data.system?.[0]?.uptime || "0m";
            uptimeSeconds = parseUptimeToSeconds(uptimeStr);
        } catch (e) {
            console.error("Uptime error:", e);
            document.getElementById("uptimeValue").innerText = "Error";
        }
    }

    async function fetchLatency() {
        try {
            const res = await fetch("http://206.189.41.115:5000/ping/8.8.8.8");
            if (!res.ok) throw new Error("Gagal fetch ping");
            const data = await res.json();
            const avgRtt = data.result?.[0]?.['avg-rtt'] || '0ms';
            const latencyMs = parseLatencyString(avgRtt);
            document.getElementById("latencyValue").innerText = `${latencyMs} ms`;
        } catch (e) {
            console.error("Latency error:", e);
        }
    }

    async function fetchChart() {
        try {
            const res = await fetch(`http://206.189.41.115:5000/traffic/graph/${encodeURIComponent(iface)}`);
            if (!res.ok) throw new Error("Gagal ambil grafik");

            const data = await res.json();

            const options = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: { show: false }
                },
                series: [
                    { name: 'Download', data: data.download },
                    { name: 'Upload', data: data.upload }
                ],
                xaxis: {
                    categories: data.categories || [],
                    title: { text: 'Waktu' }
                },
                yaxis: {
                    title: { text: 'Mbps' }
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
                dataLabels: { enabled: false },
                tooltip: {
                    y: { formatter: val => `${val} Mbps` }
                }
            };

            const chart = new ApexCharts(document.querySelector("#traffic-chart"), options);
            chart.render();

        } catch (error) {
            console.error("Chart error:", error);
            document.getElementById("traffic-chart").innerHTML = "<div class='text-danger'>Gagal memuat grafik perangkat.</div>";
        }
    }

    // Initial
    fetchRealtimeStats();
    fetchUptime();
    fetchLatency();
    fetchChart();

    // Interval updates
    setInterval(fetchRealtimeStats, 1000);
    setInterval(fetchLatency, 1000);
    setInterval(updateUptimeDisplay, 1000);
});
</script>
@endpush

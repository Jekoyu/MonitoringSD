@extends('layouts.app')

@section('title', 'Statistik Perangkat')
@section('page-title', 'Statistik Perangkat Jaringan')

@section('content')
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
    document.addEventListener("DOMContentLoaded", async function () {
        const iface = @json($device);
        document.getElementById("deviceName").innerText = iface;

        try {
            const response = await fetch(`http://206.189.41.115:5000/traffic/graph/${encodeURIComponent(iface)}`);
            if (!response.ok) throw new Error("Gagal mengambil data perangkat.");

            const data = await response.json();
            console.log("Fetched Data:", data);

            const options = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    {
                        name: 'Download',
                        data: data.download
                    },
                    {
                        name: 'Upload',
                        data: data.upload
                    }
                ],
                xaxis: {
                    categories: data.categories || [],
                    title: {
                        text: 'Waktu'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Mbps'
                    }
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
            };

            const chart = new ApexCharts(document.querySelector("#traffic-chart"), options);
            chart.render();

        } catch (error) {
            console.error("Error memuat data grafik:", error);
            document.getElementById("traffic-chart").innerHTML = "<div class='text-danger'>Gagal memuat grafik perangkat.</div>";
        }
    });
</script>
@endpush

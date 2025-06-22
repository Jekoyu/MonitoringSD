@extends('layouts.app')

@section('title', 'Speed Test Jaringan')
@section('page-title', 'Tes Kecepatan Jaringan')

@section('content')

<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
    <div class="iq-card-body">
        <div class="text-center py-3">
            <!-- Dropdown untuk memilih IP (hiasan + trigger reset iframe) -->
            <label for="ipSelect" class="mr-2 font-weight-bold">Pilih Perangkat:</label>
            <select id="ipSelect" class="form-control d-inline-block w-auto">
                <option value="192.168.10.1">192.168.10.1</option>
                <option value="192.168.20.1">192.168.20.1</option>
            </select>
        </div>

        <div class="text-center py-4">
            <!-- Iframe Speedtest -->
            <div style="text-align:center; margin: 0 auto; max-width: 100%; min-height: 600px; position: relative;">
                <iframe id="speedtestFrame"
                    style="border:none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; min-height: 600px; overflow: hidden !important;"
                    src="https://openspeedtest.com/speedtest">
                </iframe>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .iq-card-body {
        padding: 20px;
        background-color: #f7f9fa;
        border-radius: 10px;
    }

    .iq-card {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    iframe {
        max-width: 100%;
        height: 100%;
    }

    @media (max-width: 768px) {
        .iq-card-body {
            padding: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('ipSelect').addEventListener('change', function () {
        const iframe = document.getElementById('speedtestFrame');
        const currentSrc = iframe.src;

        iframe.src = '';
        setTimeout(() => {
            iframe.src = currentSrc;
        }, 100);
    });
</script>
@endpush

@extends('layouts.app')

@section('title', 'Speed Test Jaringan')
@section('page-title', 'Tes Kecepatan Jaringan')

@section('content')
<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
    <div class="iq-card-body">
        <div class="text-center py-5">
            <!-- OpenSpeedtest Widget Embed -->
            <div style="text-align:center; margin: 0 auto; max-width: 100%; min-height: 600px; position: relative;">
                <iframe style="border:none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; min-height: 600px; border: none; overflow: hidden !important;"
                    src="https://openspeedtest.com/speedtest">
                </iframe>
            </div>

            <!-- End of OpenSpeedtest Widget Embed -->
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styling untuk memastikan tampilan widget OpenSpeedtest rapi dalam layout */
    .iq-card-body {
        padding: 20px;
        background-color: #f7f9fa;
        /* Tema terang dengan latar belakang putih */
        border-radius: 10px;
    }

    .text-dark {
        color: #333 !important;
    }

    .iq-card {
        background-color: #ffffff;
        /* Latar belakang putih untuk kartu */
        border: 1px solid #ddd;
        /* Border tipis agar terlihat rapi */
        border-radius: 10px;
    }

    .text-center {
        text-align: center;
    }

    /* Menyesuaikan ukuran iframe */
    iframe {
        max-width: 100%;
        height: 100%;
    }

    /* Responsif: Menyesuaikan ukuran layar */
    @media (max-width: 768px) {
        .iq-card-body {
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }
    }
</style>
@endpush
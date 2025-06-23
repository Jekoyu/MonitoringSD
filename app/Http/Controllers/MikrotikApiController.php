<?php

namespace App\Http\Controllers;

use App\Services\MikrotikService;
use Illuminate\Support\Facades\Storage;

class MikrotikApiController extends Controller
{
    protected $mikrotik;

    public function __construct(MikrotikService $mikrotik)
    {
        $this->mikrotik = $mikrotik;
    }

    protected function fetchAndCache(string $methodName, string $cacheFile)
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                if (Storage::disk('local')->exists($cacheFile)) {
                    $cached = json_decode(Storage::get($cacheFile), true);
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Connection error, returning cached data',
                        'data' => $cached
                    ]);
                }

                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }

            $data = $this->mikrotik->{$methodName}();
            Storage::disk('local')->put($cacheFile, json_encode($data, JSON_PRETTY_PRINT));

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function interfaces()
    {
        return $this->fetchAndCache('getInterfaces', 'mikrotik/interfaces.json');
    }

    public function traffic($interface)
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }

            $data = $this->mikrotik->getInterfaceTraffic($interface);

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function arp()
    {
        return $this->fetchAndCache('getArp', 'mikrotik/arp.json');
    }

    public function dhcpLeases()
    {
        return $this->fetchAndCache('getDhcpLeases', 'mikrotik/dhcp_leases.json');
    }

    public function resource()
    {
        return $this->fetchAndCache('getResources', 'mikrotik/resource.json');
    }

    public function logs()
    {
        return $this->fetchAndCache('getLogs', 'mikrotik/logs.json');
    }

    public function systemIdentity()
    {
        return $this->fetchAndCache('getSystemIdentity', 'mikrotik/identity.json');
    }
    public function trafficHistory()
    {
        $logs = json_decode(Storage::get('mikrotik/traffic_logs.json'), true);
        $range = request()->get('range', 'daily');

        $grouped = [];

        foreach ($logs as $i => $entry) {
            $timestamp = \Carbon\Carbon::parse($entry['timestamp']);

            $key = match ($range) {
                'daily' => $timestamp->format('H:00'),
                'weekly' => $timestamp->startOfWeek()->format('Y-m-d'),
                'monthly' => $timestamp->format('Y-m'),
                default => $timestamp->format('H:00')
            };

            if (!isset($grouped[$key])) {
                $grouped[$key] = ['rx' => 0, 'tx' => 0];
            }

            if ($i > 0 && $logs[$i - 1]['interface'] === $entry['interface']) {
                $prev = $logs[$i - 1];

                $grouped[$key]['rx'] += max(0, $entry['rx'] - $prev['rx']);
                $grouped[$key]['tx'] += max(0, $entry['tx'] - $prev['tx']);
            }
        }

        // Byte → Mbps (per 5 menit ≈ 300s)
        $trafficData = [];
        foreach ($grouped as $key => $v) {
            $totalMb = round(($v['rx'] + $v['tx']) / (1024 * 1024), 2);
            $trafficData[] = [
                'time' => $key,
                'traffic' => $totalMb
            ];
        }

        return response()->json([
            'status' => 'success',
            'categories' => array_column($trafficData, 'time'),
            'traffic' => array_column($trafficData, 'traffic')
        ]);
    }
    public function bandwidthHistory()
    {
        $logs = json_decode(Storage::get('mikrotik/traffic_logs.json'), true);
        $range = request()->get('range', 'daily');

        $grouped = [];

        foreach ($logs as $i => $entry) {
            $timestamp = \Carbon\Carbon::parse($entry['timestamp']);
            $iface = $entry['interface'];

            $key = match ($range) {
                'daily' => $timestamp->format('H:00'),
                'weekly' => $timestamp->startOfWeek()->format('Y-m-d'),
                'monthly' => $timestamp->format('Y-m'),
                default => $timestamp->format('H:00'),
            };

            if (!isset($grouped[$key])) {
                $grouped[$key] = ['rx' => 0, 'tx' => 0];
            }

            if ($i > 0 && $logs[$i - 1]['interface'] === $iface) {
                $prev = $logs[$i - 1];
                $rx = $entry['rx'] - $prev['rx'];
                $tx = $entry['tx'] - $prev['tx'];
                $grouped[$key]['rx'] += max(0, $rx);
                $grouped[$key]['tx'] += max(0, $tx);
            }
        }

        $categories = array_keys($grouped);
        $download = array_map(fn($item) => round($item['rx'] / (1024 * 1024), 2), array_values($grouped));
        $upload = array_map(fn($item) => round($item['tx'] / (1024 * 1024), 2), array_values($grouped));

        return response()->json([
            'status' => 'success',
            'categories' => $categories,
            'download' => $download,
            'upload' => $upload
        ]);
    }
    public function testConnection()
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError(),
                ], 500);
            }

            $identity = $this->mikrotik->getSystemIdentity();

            return response()->json([
                'status' => 'success',
                'message' => 'Koneksi ke Mikrotik berhasil!',
                'identity' => $identity,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

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
    public function interfaceTraffic($interface)
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError(),
                ], 500);
            }

            $data = $this->mikrotik->getInterfaceTraffic($interface);

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
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

        foreach ($logs as $entry) {
            $timestamp = \Carbon\Carbon::parse($entry['timestamp']);

            $key = match ($range) {
                'daily' => $timestamp->format('H:00'),
                'weekly' => $timestamp->startOfWeek()->format('Y-m-d'),
                'monthly' => $timestamp->format('Y-m'),
                default => $timestamp->format('H:00')
            };

            if (!isset($grouped[$key])) {
                $grouped[$key] = ['rx_bps' => 0, 'tx_bps' => 0, 'count' => 0];
            }
            $grouped[$key]['rx_bps'] += $entry['rx_bps'] ?? 0;
            $grouped[$key]['tx_bps'] += $entry['tx_bps'] ?? 0;
            $grouped[$key]['count'] += 1;
        }

        // Hitung rata-rata Mbps per slot waktu
        $trafficData = [];
        foreach ($grouped as $key => $v) {
            $totalMbps = round((($v['rx_bps'] + $v['tx_bps']) / $v['count']) / 1_000_000, 2); // bits per second → Mbps
            $trafficData[] = [
                'time' => $key,
                'traffic' => $totalMbps
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

        foreach ($logs as $entry) {
            $timestamp = \Carbon\Carbon::parse($entry['timestamp']);
            $iface = $entry['interface'];

            $key = match ($range) {
                'daily' => $timestamp->format('H:00'),
                'weekly' => $timestamp->startOfWeek()->format('Y-m-d'),
                'monthly' => $timestamp->format('Y-m'),
                default => $timestamp->format('H:00'),
            };

            if (!isset($grouped[$key])) {
                $grouped[$key] = ['rx_bps' => 0, 'tx_bps' => 0, 'count' => 0];
            }

            $grouped[$key]['rx_bps'] += $entry['rx_bps'] ?? 0;
            $grouped[$key]['tx_bps'] += $entry['tx_bps'] ?? 0;
            $grouped[$key]['count'] += 1;
        }

        $categories = array_keys($grouped);
        $download = array_map(fn($item) => round(($item['rx_bps'] / $item['count']) / 1_000_000, 2), array_values($grouped));
        $upload = array_map(fn($item) => round(($item['tx_bps'] / $item['count']) / 1_000_000, 2), array_values($grouped));

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
    public function testEnv()
    {
        return response()->json([
            'mikrotik_env' => [
                'host' => env('MIKROTIK_HOST'),
                'user' => env('MIKROTIK_USER'),
                'pass' => env('MIKROTIK_PASS'),
            ],
            'mikrotik_config' => [
                'host' => config('mikrotik.host'),
                'user' => config('mikrotik.user'),
                'pass' => config('mikrotik.pass'),
            ],
            'cwd'  => getcwd(),
            'exists_env' => file_exists(base_path('.env')),
            'env_path' => base_path('.env'),
        ]);
    }
    public function latency()
    {
        try {

            $latencyMs = $this->mikrotik->getLatency(); // hasil dalam ms, contoh: 50

            return response()->json([
                'status' => 'success',
                'latency' => $latencyMs,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

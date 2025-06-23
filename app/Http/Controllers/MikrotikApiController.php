<?php

namespace App\Http\Controllers;

use App\Services\MikrotikService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MikrotikApiController extends Controller
{
    protected $mikrotik;

    public function __construct(MikrotikService $mikrotik)
    {
        $this->mikrotik = $mikrotik;
    }

    protected function fetchAndCache(string $methodName, string $cacheKey)
    {
        try {
            $cacheKey = 'mikrotik:' . $cacheKey;

            if ($this->mikrotik->hasConnectionError()) {
                $cached = Cache::get($cacheKey);
                if ($cached) {
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Connection error, returning cached data from Redis',
                        'data' => $cached
                    ]);
                }

                return response()->json([
                    'status' => 'error',
                    'message' => $this->mikrotik->getConnectionError()
                ], 500);
            }

            $data = $this->mikrotik->{$methodName}();

            Cache::put($cacheKey, $data, now()->addMinutes(5));

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

    public function interfaces()        { return $this->fetchAndCache('getInterfaces', 'interfaces'); }
    public function arp()              { return $this->fetchAndCache('getArp', 'arp'); }
    public function dhcpLeases()       { return $this->fetchAndCache('getDhcpLeases', 'dhcp_leases'); }
    public function resource()         { return $this->fetchAndCache('getResources', 'resource'); }
    public function logs()             { return $this->fetchAndCache('getLogs', 'logs'); }
    public function systemIdentity()   { return $this->fetchAndCache('getSystemIdentity', 'identity'); }

    public function interfaceTraffic($interface)
    {
        try {
            if ($this->mikrotik->hasConnectionError()) {
                return response()->json(['status' => 'error', 'message' => $this->mikrotik->getConnectionError()], 500);
            }

            $data = $this->mikrotik->getInterfaceTraffic($interface);

            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function traffic($interface)
    {
        return $this->interfaceTraffic($interface);
    }

    public function trafficHistory(Request $request)
    {
        $logs = json_decode(Cache::get('mikrotik:traffic_logs'), true);

        if (!$logs || !is_array($logs)) {
            return response()->json(['status' => 'error', 'message' => 'Traffic logs not found in Redis'], 404);
        }

        $range = $request->get('range', 'daily');
        $grouped = [];

        foreach ($logs as $entry) {
            $timestamp = Carbon::parse($entry['timestamp']);
            $key = match ($range) {
                'daily' => $timestamp->format('H:00'),
                'weekly' => $timestamp->startOfWeek()->format('Y-m-d'),
                'monthly' => $timestamp->format('Y-m'),
                default => $timestamp->format('H:00')
            };

            $grouped[$key]['rx_bps'] = ($grouped[$key]['rx_bps'] ?? 0) + ($entry['rx_bps'] ?? 0);
            $grouped[$key]['tx_bps'] = ($grouped[$key]['tx_bps'] ?? 0) + ($entry['tx_bps'] ?? 0);
            $grouped[$key]['count'] = ($grouped[$key]['count'] ?? 0) + 1;
        }

        $trafficData = [];
        foreach ($grouped as $key => $v) {
            $totalMbps = round((($v['rx_bps'] + $v['tx_bps']) / $v['count']) / 1_000_000, 2);
            $trafficData[] = ['time' => $key, 'traffic' => $totalMbps];
        }

        return response()->json([
            'status' => 'success',
            'categories' => array_column($trafficData, 'time'),
            'traffic' => array_column($trafficData, 'traffic')
        ]);
    }

    public function bandwidthHistory(Request $request)
    {
        $logs = json_decode(Cache::get('mikrotik:traffic_logs'), true);

        if (!$logs || !is_array($logs)) {
            return response()->json(['status' => 'error', 'message' => 'Traffic logs not found in Redis'], 404);
        }

        $range = $request->get('range', 'daily');
        $grouped = [];

        foreach ($logs as $entry) {
            $timestamp = Carbon::parse($entry['timestamp']);
            $key = match ($range) {
                'daily' => $timestamp->format('H:00'),
                'weekly' => $timestamp->startOfWeek()->format('Y-m-d'),
                'monthly' => $timestamp->format('Y-m'),
                default => $timestamp->format('H:00')
            };

            $grouped[$key]['rx_bps'] = ($grouped[$key]['rx_bps'] ?? 0) + ($entry['rx_bps'] ?? 0);
            $grouped[$key]['tx_bps'] = ($grouped[$key]['tx_bps'] ?? 0) + ($entry['tx_bps'] ?? 0);
            $grouped[$key]['count'] = ($grouped[$key]['count'] ?? 0) + 1;
        }

        $categories = array_keys($grouped);
        $download = array_map(fn($v) => round(($v['rx_bps'] / $v['count']) / 1_000_000, 2), array_values($grouped));
        $upload = array_map(fn($v) => round(($v['tx_bps'] / $v['count']) / 1_000_000, 2), array_values($grouped));

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
                return response()->json(['status' => 'error', 'message' => $this->mikrotik->getConnectionError()], 500);
            }

            $identity = $this->mikrotik->getSystemIdentity();

            return response()->json([
                'status' => 'success',
                'message' => 'Koneksi ke Mikrotik berhasil!',
                'identity' => $identity,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
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
            $latencyMs = $this->mikrotik->getLatency();
            return response()->json(['status' => 'success', 'latency' => $latencyMs]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function uptime()
    {
        try {
            $resources = $this->mikrotik->getResources();
            $uptimeRaw = is_array($resources) && isset($resources[0]['uptime']) ? $resources[0]['uptime'] : '0s';
            $seconds = $this->parseUptimeToSeconds($uptimeRaw);

            return response()->json(['status' => 'success', 'uptime' => $seconds]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function parseUptimeToSeconds(string $uptimeStr): int
    {
        $seconds = 0;
        if (preg_match('/(\d+)d/', $uptimeStr, $matches)) $seconds += $matches[1] * 86400;
        if (preg_match('/(\d+)h/', $uptimeStr, $matches)) $seconds += $matches[1] * 3600;
        if (preg_match('/(\d+)m/', $uptimeStr, $matches)) $seconds += $matches[1] * 60;
        if (preg_match('/(\d+)s/', $uptimeStr, $matches)) $seconds += $matches[1];
        return $seconds;
    }
}

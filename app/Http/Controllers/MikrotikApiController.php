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
            // Optional: bisa cache juga ke file, tergantung kebutuhan
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
}

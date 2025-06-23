<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\MikrotikService;

class LogMikrotikTraffic extends Command
{
    protected $signature = 'mikrotik:log-traffic';
    protected $description = 'Log MikroTik interface traffic bandwidth periodically';

    protected $mikrotik;

    public function __construct(MikrotikService $mikrotik)
    {
        parent::__construct();
        $this->mikrotik = $mikrotik;
    }

    public function handle()
    {
        if ($this->mikrotik->hasConnectionError()) {
            $this->error('Mikrotik connection failed');
            return;
        }

        // Ambil semua interface, filter yang online saja (running == "true")
        $allInterfaces = $this->mikrotik->getInterfaces();
        $onlineInterfaces = array_filter($allInterfaces, function ($iface) {
            return isset($iface['running']) && $iface['running'] === 'true';
        });

        $filename = 'mikrotik/traffic_logs.json';

        $logs = Storage::exists($filename)
            ? json_decode(Storage::get($filename), true)
            : [];

        foreach ($onlineInterfaces as $ifaceData) {
            $ifaceName = $ifaceData['name'] ?? null;
            // Skip jika lo atau wg0
            if (!$ifaceName || in_array($ifaceName, ['lo', 'wg0'])) continue;

            $trafficArray = $this->mikrotik->getInterfaceTraffic($ifaceName);
            $traffic = $trafficArray[0] ?? [];

            $logs[] = [
                'timestamp' => now()->toDateTimeString(),
                'interface' => $ifaceName,
                'rx_bps'    => isset($traffic['rx-bits-per-second']) ? (int)$traffic['rx-bits-per-second'] : 0,
                'tx_bps'    => isset($traffic['tx-bits-per-second']) ? (int)$traffic['tx-bits-per-second'] : 0
            ];
        }


        Storage::put($filename, json_encode($logs, JSON_PRETTY_PRINT));
        $this->info("Traffic bandwidth for all online interfaces logged.");
    }
}

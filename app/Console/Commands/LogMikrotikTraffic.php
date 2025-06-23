<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
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

        $allInterfaces = $this->mikrotik->getInterfaces();
        $onlineInterfaces = array_filter($allInterfaces, function ($iface) {
            return isset($iface['running']) && $iface['running'] === 'true';
        });

        // Ambil log lama dari Redis
        $logs = Cache::get('mikrotik:traffic_logs', []);

        foreach ($onlineInterfaces as $ifaceData) {
            $ifaceName = $ifaceData['name'] ?? null;
            if (!$ifaceName || in_array($ifaceName, ['lo', 'wg0'])) continue;

            try {
                $trafficArray = $this->mikrotik->getInterfaceTraffic($ifaceName);
                $traffic = $trafficArray[0] ?? [];

                $logs[] = [
                    'timestamp' => now()->toDateTimeString(),
                    'interface' => $ifaceName,
                    'rx_bps'    => (int)($traffic['rx-bits-per-second'] ?? 0),
                    'tx_bps'    => (int)($traffic['tx-bits-per-second'] ?? 0),
                ];
            } catch (\Exception $e) {
                \Log::warning("Gagal ambil traffic $ifaceName: " . $e->getMessage());
            }
        }

        // Simpan kembali log ke Redis (set TTL opsional jika diinginkan)
        Cache::put('mikrotik:traffic_logs', $logs, now()->addDays(7));

        $this->info("Traffic bandwidth for all online interfaces logged to Redis.");
        \Log::info('mikrotik:log-traffic command run at ' . now());
    }
}
